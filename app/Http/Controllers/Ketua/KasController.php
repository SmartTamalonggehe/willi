<?php

namespace App\Http\Controllers\Ketua;

use Carbon\Carbon;
use App\Models\Kas;
use Illuminate\Http\Request;
use App\Exports\KasUmumExcel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;

class KasController extends Controller
{
    public function tampilKas(Request $request)
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


        $tahun=Kas::get()->keyBy(function($d) {
            return Carbon::parse($d->tgl_kas)->format('Y');
        });

        $kas = Kas::orderBy('tgl_kas')->whereMonth('tgl_kas', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

        if ($request->tahun and $request->bulan) {

            $kas = Kas::orderBy('tgl_kas')->whereMonth('tgl_kas', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

            $totalLalu = Kas::orderBy('tgl_kas')->with('transaksi')->whereMonth('tgl_kas', '<', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

            $forPersenLalu = QueryBuilder::for(Kas::orderBy('tgl_kas')
                    ->whereMonth('tgl_kas','<', $request->bulan)
                    ->whereYear('tgl_kas',$request->tahun))
                    ->with('transaksi')
                    ->allowedFilters(['transaksi.nm_transaksi'])
                    ->get();

            $totalSkrg = Kas::orderBy('tgl_kas')->with('transaksi')->whereMonth('tgl_kas', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

            $forPersenSkrg = QueryBuilder::for(Kas::orderBy('tgl_kas')
                    ->whereMonth('tgl_kas', $request->bulan)
                    ->whereYear('tgl_kas',$request->tahun))
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

        }

            if ($request->ajax()) {
                $view = view('ketua.kas.data', [
                    'kas'=>$kas,
                    'saldo_awal'=>$saldoLalu,
                    'presentaseSkrg'=>$presentaseSkrg,
                    'sisaSaldo'=>$sisaSaldo,
                    'perpuluhan'=>$perpuluhan,
                ]);
                return $view;
            }
            return view('ketua.kas.index',[
                'tahun'=>$tahun,
            ]);

    }

    public function kasExportExcel(Request $request)
    {
        return Excel::download(new KasUmumExcel($request->tahun,$request->bulan), "Buku Kas Umum $request->bulan $request->tahun.xlsx");
    }
}
