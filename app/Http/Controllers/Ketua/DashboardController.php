<?php

namespace App\Http\Controllers\Ketua;

use Carbon\Carbon;
use App\Models\Kas;
use Illuminate\Http\Request;
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
            ->whereYear('tgl_kas',$kasBulanIni)
            ->get();

        return view('ketua.dashboard.index',compact('kasTahunIni','kasBulanIni'));
    }
}
