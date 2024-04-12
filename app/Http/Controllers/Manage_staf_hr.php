<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pejabat_struktural;
use App\models\Divisi;

class Manage_staf_hr extends Controller
{
    public function index()
    {
        $data['staf_hr'] = Pejabat_struktural::all();
        return view('manage_staf_hr', $data);
    }

    public function create()
    {
        return view('form_staf_hr');
    }

    public function store(Request $request)
    {
        $staf_hr = Pejabat_struktural::where([
            'id_pejabat_struktural' => $request->segment(3)
        ])->first();
        $data = $request->all();
            $simpan = Pejabat_struktural::create($data);
            if ($request->hasFile('image')) {
                $request->file('image')->move('tanda_tangan/', $request->file('image')->getClientOriginalName());
                $simpan->image = $request->file('image')->getClientOriginalName();
                $simpan->save();
         }
            return redirect(Session('user')['role'].'/manage-pejabat-struktural')->with('success', 'Berhasil membuat pejabat struktural');

    }

    public function edit(Request $request)
    {
        $data['staf_hr'] = Pejabat_struktural::where([
            'id_pejabat_struktural' => $request->segment(3)
        ])->first();
        return view('form_staf_hr', $data);
    }

    public function update(Request $request)
    {
        $data = Pejabat_struktural::where([
            'id_pejabat_struktural' => $request->segment(3)
        ])->first();
        $data->nama_pejabat_struktural=$request->nama_pejabat_struktural;
        $data->jabatan=$request->jabatan;
        $data->email=$request->email;
        $data->image=$request->image;
        if ($data->save()){
            if ($request->hasFile('image') ) {
                $request->file('image')->move('tanda_tangan/', $request->file('image')->getClientOriginalName());
                $data->image = $request->file('image')->getClientOriginalName();
                $data->save();
            }
            return redirect(Session('user')['role'].'/manage-pejabat-struktural')->with('success', 'Berhasil memperbarui pejabat struktural');
        }else{
            return redirect(Session('user')['role'].'/manage-pejabat-struktural')->with('failed', 'Berhasil memperbarui pejabat struktural');
        }
        }

    public function show(){

    }

    public function destroy(Request $request)
    {
        $staf_hr = Pejabat_struktural::find($request->segment(3));
        if ($staf_hr->delete()) {
            return redirect(Session('user')['role'].'/manage-pejabat-struktural')->with('success', 'Berhasil menghapus pejabat struktural');
        } else {
            return redirect(Session('user')['role'].'/manage-pejabat-struktural')->with('failed', 'Gagal menghapus pejabat struktural');
        }
    }
}
