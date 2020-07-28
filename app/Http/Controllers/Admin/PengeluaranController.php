<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kas;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pengeluaran=Kas::orderByDesc('tgl_kas')->with('transaksi')->get()->where('transaksi.jenis_transaksi','pengeluaran');
        $jenisPengeluaran=Transaksi::orderBy('nm_transaksi')->where('jenis_transaksi','pengeluaran')->get();
        // return $jadwal;
        
        if ($request->ajax()) {
            $view = view('admin.pengeluaran.data', [
                'pengeluaran'=>$pengeluaran,
            ]);
            return $view;
        } 
        return view('admin.pengeluaran.index',[
            'jenisPengeluaran'=>$jenisPengeluaran
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
        $tgl_pengeluaran=Carbon::parse($request->tgl_kas)->format('Y-m-d');
        $jmlh_pengeluaran=filter_var($request->pengeluaran, FILTER_SANITIZE_NUMBER_INT);

        $data = Kas::create([
            'tgl_kas'=>$tgl_pengeluaran,
            'transaksi_id'=>$request->transaksi_id,
            'pemasukan'=>0,
            'pengeluaran'=>$jmlh_pengeluaran,
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
        $pengeluaran = Kas::find($id);
        return $pengeluaran;
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
        $tgl_pengeluaran=Carbon::parse($request->tgl_kas)->format('Y-m-d');
        $jmlh_pengeluaran=filter_var($request->pengeluaran, FILTER_SANITIZE_NUMBER_INT);

        Kas::where('id',$id)
            ->update([
                'tgl_kas'=>$tgl_pengeluaran,
                'transaksi_id'=>$request->transaksi_id,
                'pemasukan'=>0,
                'pengeluaran'=>$jmlh_pengeluaran,
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
