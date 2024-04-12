<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pengajuan_cuti_non;

class Print_non_tahunan extends Controller
{
    public function show(Request $request)
    {
        $data['cuti_non'] = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')->join('divisi','divisi.id','=','cuti_non.divisi_id')->join('jabatan','jabatan.id','=','pegawai.jabatan_id')->where([
            'id_cuti_non' => $request->segment(3)
        ])->select('cuti_non.*', 'pegawai.*','divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->first();
        // dd($data);
        return view('print_non_tahunan', $data);
    }
}
