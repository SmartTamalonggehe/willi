<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Perpuluhan;
use Illuminate\Http\Request;

class PerpuluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpuluhan = Perpuluhan::orderBy('id', 'DESC')->orderBy('tgl_perpuluhan', 'DESC')->get();
        // return $perpuluhan;
        if ($request->ajax()) {
            $view = view('admin.perpuluhan.data', [
                'perpuluhan' => $perpuluhan,
            ]);
            return $view;
        }
        return view('admin.perpuluhan.index');
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
        $jumlah = filter_var($request->jumlah, FILTER_SANITIZE_NUMBER_INT);

        Perpuluhan::create([
            'transaksi_id' => 7,
            'nm_jemaat' => $request->nm_jemaat,
            'jumlah' => $jumlah,
            'tgl_perpuluhan' => $request->tgl_perpuluhan,
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
        $perpuluhan = Perpuluhan::find($id);
        $pdf = PDF::loadView('admin.perpuluhan.cetak', [
            'perpuluhan' => $perpuluhan
        ]);
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Perpuluhan::find($id);
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
        $jumlah = filter_var($request->jumlah, FILTER_SANITIZE_NUMBER_INT);

        Perpuluhan::where('id', $id)
            ->update([
                'transaksi_id' => 7,
                'nm_jemaat' => $request->nm_jemaat,
                'jumlah' => $jumlah,
                'tgl_perpuluhan' => $request->tgl_perpuluhan,
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
        Perpuluhan::destroy($id);
    }
}
