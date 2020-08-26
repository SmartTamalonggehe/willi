<?php

namespace App\Exports;


use App\Models\Kas;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use Spatie\QueryBuilder\QueryBuilder;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KasUmumExcel implements FromView, ShouldAutoSize, WithEvents
{

    private $tahun;
    private $bulan;
    private $bulan_akhir;

    public function __construct($tahun,$bulan,$bulan_akhir)
    {
         $this->tahun = $tahun;
         $this->bulan = $bulan;
         $this->bulan_akhir = $bulan_akhir;
    }

    public function view(): View
    {
        $pemasukan=0;
        $pengeluaran=0;
        $perpuluhan=0;
        $saldoSkrg=0;

        $pemasukanLalu=0;
        $pengeluaranLalu=0;
        $perpuluhanLalu=0;
        $presentaseLalu=0;

        $saldoLalu=0;
        $sisaSaldo=0;
        $presentaseSkrg=0;

        $kas = Kas::orderBy('tgl_kas')
        ->whereBetween('tgl_kas', ["$this->tahun-$this->bulan-01","$this->tahun-$this->bulan_akhir-31"])
            ->get();



        $totalLalu = Kas::orderBy('tgl_kas')->with('transaksi')->whereMonth('tgl_kas', '<', $this->bulan)->whereYear('tgl_kas',$this->tahun)->get();

        $forPersenLalu = QueryBuilder::for(Kas::orderBy('tgl_kas')
                    ->whereMonth('tgl_kas','<', $this->bulan)
                    ->whereYear('tgl_kas',$this->tahun))
                    ->with('transaksi')
                    ->allowedFilters(['transaksi.nm_transaksi'])
                    ->get();

        $totalSkrg = Kas::orderBy('tgl_kas')->with('transaksi')->whereMonth('tgl_kas', $this->bulan)->whereYear('tgl_kas',$this->tahun)->get();

        $forPersenSkrg = QueryBuilder::for(Kas::orderBy('tgl_kas')
                    ->whereMonth('tgl_kas', $this->bulan)
                    ->whereYear('tgl_kas',$this->tahun))
                    ->with('transaksi')
                    ->allowedFilters(['transaksi.nm_transaksi'])
                    ->get();

        // Perulangan Perpuluhan Bulan Lalu
        foreach ($totalLalu->where('transaksi.nm_transaksi','LIKE','Perpuluhan') as $item){
        $perpuluhanLalu+=$item->pemasukan;
        }

        // Perulangan Persen Bulan Lalu
        foreach ($forPersenLalu as $item){
            $presentaseLalu+=$item->pemasukan;
        }

        // Perulangan Saldo Bln Lalu
        foreach ($totalLalu as $item) {
            $pemasukanLalu += $item->pemasukan;
            $pengeluaranLalu += $item->pengeluaran;
            $saldoLalu= $pemasukanLalu-$pengeluaranLalu;
        }

        // Rumus Menghitung Saldo Bln Lalu
        // Saldo setelah dipotong perpuluhan
        $saldoLalu=$saldoLalu-$perpuluhanLalu;
        $swj40Lalu=((40/100)*$presentaseLalu) + $perpuluhan;
        $swj20Lalu=(20/100)*$presentaseLalu;

        $saldoLalu=$saldoLalu-($swj40Lalu+$swj20Lalu);

        // Perulangan Saldo Sekarang
        foreach ($totalSkrg as $item) {
            $pemasukan += $item->pemasukan;
            $pengeluaran += $item->pengeluaran;
            $saldoSkrg= $pemasukan-$pengeluaran;
        }
        // Perulangan Perpuluhan Sekarang
        foreach ($totalSkrg->where('transaksi.nm_transaksi','Perpuluhan') as $item){
            $perpuluhan+=$item->pemasukan;
        }
        // Perulangan Persentae Sekarang
        foreach ($forPersenSkrg as $item){
            $presentaseSkrg+=$item->pemasukan;
        }

        // Rumus Saldo Sekarang
        // Saldo setelah dipotong perpuluhan
        $saldoSkrg=$saldoSkrg-$perpuluhan;
        $swj40=(40/100)*$saldoSkrg;
        $swj40Perpuluahan=$swj40 + $perpuluhan;
        $swj20=(20/100)*$saldoSkrg;

        $sisaSaldo=$saldoSkrg-($swj40+$swj20);


        return view('admin.exports.excel', [
            'kas'=>$kas,
            'saldo_awal'=>$saldoLalu,
            'presentaseSkrg'=>$presentaseSkrg,
            'sisaSaldo'=>$sisaSaldo,
            'perpuluhan'=>$perpuluhan,
        ]);



    }

    public function registerEvents() : array
    {
        return [
            // Handle by a closure.
            AfterSheet::class    => function(AfterSheet $event) {

                // Header
                $styleArray = [
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['Hex' => '#000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:F3')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('A1:F3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:F5')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A4:F5')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A4:F4')->getFont()->setSize(8);
                $event->sheet->getDelegate()->mergeCells('A1:F1');
                $event->sheet->getDelegate()->mergeCells('A2:F2');
                $event->sheet->getDelegate()->mergeCells('A3:F3');
                $event->sheet->getDelegate()->mergeCells('A4:F4');
                $event->sheet->getDelegate()->mergeCells('A5:F5');
                $event->sheet->setFontFamily('A1:AC300', 'Times New Roman');
                $event->sheet->horizontalAlign('A1:F1' , Alignment::HORIZONTAL_CENTER);
                $event->sheet->horizontalAlign('A2:F2' , Alignment::HORIZONTAL_CENTER);
                $event->sheet->horizontalAlign('A3:F3' , Alignment::HORIZONTAL_CENTER);
                $event->sheet->horizontalAlign('A4:F4' , Alignment::HORIZONTAL_CENTER);
                $event->sheet->horizontalAlign('A5:F5' , Alignment::HORIZONTAL_CENTER);


                $event->sheet->getDelegate()->getStyle('A4:F4')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('B9:F9')->getFont()->setBold(true);

                $event->sheet->getColumnDimension('A')->setWidth(12);

                // Content

                $styleContent = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];


                // $kontrak=DB::table('kontrak')->where('jadwal_id',$this->id)
                //     ->join('krs','kontrak.krs_id','krs.id')
                //     ->join('perwalians','krs.perwalian_id','perwalians.id')
                //     ->join('mhs','perwalians.mhs_id','mhs.id')
                //     ->orderByDesc('NPM')
                //     ->get();

                // $akhir = $kontrak->count() + 9 ;


                // // $event->sheet->getDelegate()->getStyle('B3:B7')->getFill()
                // //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                // //     ->getStartColor()->setARGB('FFFF0000');

                // $event->sheet->getDelegate()->getStyle("B9:F$akhir")->applyFromArray($styleContent);

                // $event->sheet->getDefaultRowDimension("B9:F$akhir")->setRowHeight(20);

            },
        ];
    }


}
