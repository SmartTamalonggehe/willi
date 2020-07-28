<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kas;
use Illuminate\Http\Request;
use App\Exports\KasUmumExcel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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
        $saldoLalu=0;
        $sisaSaldo=0;


        $tahun=Kas::get()->keyBy(function($d) {
            return Carbon::parse($d->tgl_kas)->format('Y');
        });

        $kas = Kas::orderBy('tgl_kas')->whereMonth('tgl_kas', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

        if ($request->tahun and $request->bulan) {

            $kas = Kas::orderBy('tgl_kas')->whereMonth('tgl_kas', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

            $totalLalu = Kas::orderBy('tgl_kas')->with('transaksi')->whereMonth('tgl_kas', '<', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

            $totalSkrg = Kas::orderBy('tgl_kas')->with('transaksi')->whereMonth('tgl_kas', $request->bulan)->whereYear('tgl_kas',$request->tahun)->get();

            // Perulangan Perpuluhan Bulan Lalu
            foreach ($totalLalu->where('transaksi.nm_transaksi','LIKE','Perpuluhan') as $item){
            $perpuluhanLalu+=$item->pemasukan;
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
        $swj40Lalu=((40/100)*$saldoLalu) + $perpuluhan;
        $swj20Lalu=(20/100)*$saldoLalu;

        $saldoLalu=$saldoLalu-($swj40Lalu+$swj20Lalu);

        // Perulangan Saldo Sekarang
        foreach ($totalSkrg as $item) {
            $pemasukan += $item->pemasukan;
            $pengeluaran += $item->pengeluaran;
            $saldoSkrg= $pemasukan-$pengeluaran;
        }
        // Perulangan Perpuluhan Sekarang
        foreach ($totalSkrg->where('transaksi.nm_transaksi','LIKE','Perpuluhan') as $item){
            $perpuluhan+=$item->pemasukan;
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
            $view = view('admin.kas.data', [
                'kas'=>$kas,
                'saldo_awal'=>$saldoLalu,
                // 'swj40'=>$swj40,
                // 'swj20'=>$swj20,
                // 'swj40Perpuluahan'=>$swj40Perpuluahan,
                'sisaSaldo'=>$sisaSaldo,
                'perpuluhan'=>$perpuluhan,
            ]);
            return $view;
        }
        return view('admin.kas.index',[
            'tahun'=>$tahun,
        ]);
    }

    public function kasExportExcel(Request $request)
    {
        return Excel::download(new KasUmumExcel($request->tahun,$request->bulan), "Buku Kas Umum $request->bulan $request->tahun.xlsx");
    }
}
