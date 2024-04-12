<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pengajuan_cuti;
use App\models\View_sisa_cuti;


class Print_tahunan extends Controller
{
    public function show(Request $request)
    {
        $data['pengajuan_cuti'] = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')->join('divisi','divisi.id','=','pengajuan_cuti.divisi_id')->join('jabatan','jabatan.id','=','pegawai.jabatan_id')->where([
            'id_pengajuan_cuti' => $request->segment(3)
        ])->select('pengajuan_cuti.*', 'pegawai.*','divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->first();
        $id_karyawan = Session('user')['id'];
        $sisa_cuti = View_sisa_cuti::where([
            'pegawai_id' => $id_karyawan,
            // 'tahun' => date('Y')
        ])
        ->first();
        $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
            'pegawai_id' => $id_karyawan,
            'status' => 'verifikasi'
        ])
        ->where('tanggal_pengajuan','like',date('Y')."%")
        ->count();
        $total_pengajuan_cuti = pengajuan_cuti::where([
            'pegawai_id' => $id_karyawan,
        ])
        ->where('tanggal_pengajuan','like',date('Y')."%")
        ->count();
        $data['cuti_terpakai'] = $sisa_cuti->cuti_terpakai;
        $data['sisa_cuti'] = $sisa_cuti->sisa_cuti;
        $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        $data['jumlah_cuti'] = $sisa_cuti->jumlah_cuti;
        $data['cuti_bersama'] = $sisa_cuti->cuti_bersama;
        // dd($data);
        return view('print_tahunan', $data);
    }
}
