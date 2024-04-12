<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Konfig_cuti;

class Konfigurasi_cuti extends Controller
{
    public function index()
    {
        $data['konfigurasi_cuti'] = Konfig_cuti::all();
        return view('konfigurasi_cuti', $data);
    }

    public function create()
    {
        return view('form_konfigurasi_cuti');
    }

    public function store(Request $request)
    {
        if (Konfig_cuti::create($request->all())) {
            return redirect(Session('user')['role'].'/konfigurasi-cuti')->with('success', 'Berhasil membuat konfigurasi_cuti');
        } else {
            return redirect(Session('user')['role'].'/konfigurasi-cuti')->with('failed', 'Gagal membuat konfigurasi_cuti');
        }
    }

    public function edit(Request $request)
    {
        $data['konfigurasi_cuti'] = Konfig_cuti::where([
            'id_konfig_cuti' => $request->segment(3)
        ])->first();
        return view('form_konfigurasi_cuti', $data);
    }

    public function update(Request $request)
    {
        $konfigurasi_cuti = Konfig_cuti::where([
            'id_konfig_cuti' => $request->segment(3)
        ])->first();
        $konfigurasi_cuti->tahun = $request->tahun;
        $konfigurasi_cuti->cuti_bersama = $request->cuti_bersama;
        $konfigurasi_cuti->jumlah_cuti = $request->jumlah_cuti;
        if ($konfigurasi_cuti->save()) {
            return redirect(Session('user')['role'].'/konfigurasi-cuti')->with('success', 'Berhasil memperbarui konfigurasi_cuti');
        } else {
            return redirect(Session('user')['role'].'/konfigurasi-cuti')->with('failed', 'Gagal memperbarui konfigurasi_cuti');
        }
    }

    public function show(){

    }

    public function destroy(Request $request)
    {
        $konfigurasi_cuti = Konfig_cuti::find($request->segment(3));
        if ($konfigurasi_cuti->delete()) {
            return redirect(Session('user')['role'].'/konfigurasi-cuti')->with('success', 'Berhasil menghapus konfigurasi_cuti');
        } else {
            return redirect(Session('user')['role'].'/konfigurasi-cuti')->with('failed', 'Gagal menghapus konfigurasi_cuti');
        }
    }
}
