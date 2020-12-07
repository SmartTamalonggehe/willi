<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pemasukan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\JenisPemasukan;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Kas;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pemasukan = Kas::orderByDesc('tgl_kas')->with('transaksi')->get()->where('transaksi.jenis_transaksi', 'pemasukan');
        $jenisPemasukan = Transaksi::orderBy('nm_transaksi')->where('jenis_transaksi', 'pemasukan')->get();
        // return $jadwal;

        if ($request->ajax()) {
            $view = view('admin.pemasukan.data', [
                'pemasukan' => $pemasukan,
            ]);
            return $view;
        }
        return view('admin.pemasukan.index', [
            'jenisPemasukan' => $jenisPemasukan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tgl_pemasukan = Carbon::parse($request->tgl_kas)->format('Y-m-d');
        $jmlh_pemasukan = filter_var($request->pemasukan, FILTER_SANITIZE_NUMBER_INT);

        $data = Kas::create([
            'tgl_kas' => $tgl_pemasukan,
            'transaksi_id' => $request->transaksi_id,
            'pemasukan' => $jmlh_pemasukan,
            'pengeluaran' => 0,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tool = Kas::find($id);
        return $tool;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tgl_pemasukan = Carbon::parse($request->tgl_kas)->format('Y-m-d');
        $jmlh_pemasukan = filter_var($request->pemasukan, FILTER_SANITIZE_NUMBER_INT);

        Kas::where('id', $id)
            ->update([
                'tgl_kas' => $tgl_pemasukan,
                'transaksi_id' => $request->transaksi_id,
                'pemasukan' => $jmlh_pemasukan,
                'pengeluaran' => 0,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kas::destroy($id);
    }
}
