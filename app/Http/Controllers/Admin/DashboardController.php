<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunIni=Carbon::now()->format('Y');
        $kasBulanIni=Carbon::now()->format('m');
        $mingguIni=Carbon::now()->format('Y');

        $kasTahunIni=Kas::orderBy('tgl_kas')
            ->whereYear('tgl_kas',$tahunIni)
            ->get();

        $kasBulanIni=Kas::orderBy('tgl_kas')
            ->whereMonth('tgl_kas',$kasBulanIni)
            ->whereYear('tgl_kas',$tahunIni)
            ->get();

        return view('admin.dashboard.index',compact('kasTahunIni','kasBulanIni'));
    }

    public function kasGrafik()
    {
        $tahunIni=Carbon::now()->format('Y');
        $kasTahunIni=Kas::orderBy('tgl_kas')
            ->whereYear('tgl_kas',$tahunIni)
            ->get();

        $pemasukan=Kas::whereYear('tgl_kas',$tahunIni)
            ->selectRaw('SUM(pemasukan) as pemasukan, MONTH(tgl_kas) as bulan')
            ->groupBy('bulan')->get();

        $pengeluaran=Kas::whereYear('tgl_kas',$tahunIni)
            ->selectRaw('SUM(pengeluaran) as pengeluaran, MONTH(tgl_kas) as bulan')
            ->groupBy('bulan')->get();


        $kasTahunIni->keyBy('tgl_kas');

        return response()->json([
            'pemasukan'=>$pemasukan,
            'pengeluaran'=>$pengeluaran,

        ]);
    }
}
