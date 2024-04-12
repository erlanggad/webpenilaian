<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\View_sisa_cuti;
use App\models\Pengajuan_cuti;
use App\models\Karyawan;
use App\Models\Pegawai;
use App\models\Pejabat_struktural;

class Home extends Controller
{
    public function index(Request $request)
    {
        $role = Session('user')['role'];
        switch ($role) {
            case 'karyawan':
                # code...
                return $this->index_karyawan($request);
                break;
            case 'Kepala Bagian':
                # code...
                return $this->index_kepala_bagian($request);
                break;

            case 'Kepala Sub Bagian':
                # code...
                return $this->index_kepala_sub_bagian($request);
                break;
            case 'Direktur':
                # code...
                return $this->index_direktur($request);
                break;
            case 'admin':
                # code...
                return $this->index_admin($request);
                break;

            default:
                # code...
                return redirect('/login');
                break;
        }
    }

    // private function index_karyawan($request){
    //     $id_karyawan = Session('user')['id_karyawan'];
    //     $sisa_cuti = View_sisa_cuti::where([
    //         'id_karyawan' => $id_karyawan,
    //         'tahun' => date('Y')
    //     ])
    //     ->first();
    //     $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
    //         'id_karyawan' => $id_karyawan,
    //         'status' => 'verifikasi'
    //     ])
    //     ->where('tanggal_pengajuan','like',date('Y')."%")
    //     ->count();
    //     $total_pengajuan_cuti = pengajuan_cuti::where([
    //         'id_karyawan' => $id_karyawan,
    //     ])
    //     ->where('tanggal_pengajuan','like',date('Y')."%")
    //     ->count();
    //     $data['cuti_terpakai'] = $sisa_cuti->cuti_terpakai;
    //     $data['sisa_cuti'] = $sisa_cuti->sisa_cuti;
    //     $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
    //     $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
    //     return view('home_karyawan',$data);
    // }

    private function index_karyawan($request)
    {
        // $id_karyawan = Session('user')['id'];
        // $sisa_cuti = View_sisa_cuti::where([
        //     'pegawai_id' => $id_karyawan,
        //     'tahun' => date('Y')
        // ])
        //     ->first();
        // // dd($sisa_cuti);
        // $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
        //     'pegawai_id' => $id_karyawan,
        //     'status' => 'verifikasi'
        // ])
        //     ->where('tanggal_pengajuan', 'like', date('Y') . "%")
        //     ->count();
        // $total_pengajuan_cuti = pengajuan_cuti::where([
        //     'pegawai_id' => $id_karyawan,
        // ])
        //     ->where('tanggal_pengajuan', 'like', date('Y') . "%")
        //     ->count();
        // $data['cuti_terpakai'] = $sisa_cuti->cuti_terpakai;
        // $data['sisa_cuti'] = $sisa_cuti->sisa_cuti;
        // $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        // $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        return view('home_karyawan');
    }

    private function index_kepala_bagian($request)
    {
        $role = Session('user')['divisi'];

        $jumlah_karyawan = Pegawai::where('jabatan_id', '!=', '1')->where('divisi_id', '=', $role)->count();
        // $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
        //     'status' => 'verifikasi'
        // ])
        // ->where('tanggal_pengajuan','like',date('Y')."%")
        // ->count();
        // $total_pengajuan_cuti = pengajuan_cuti::where('tanggal_pengajuan','like',date('Y')."%")->count();
        $data['jumlah_karyawan'] = $jumlah_karyawan;
        // $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        // $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        return view('home_kepala_bagian', $data);
    }

    private function index_kepala_sub_bagian($request)
    {
        $role = Session('user')['divisi'];

        $jumlah_karyawan = Pegawai::where('jabatan_id', '!=', '1')->where('divisi_id', '=', $role)->count();
        // $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
        //     'status' => 'verifikasi'
        // ])
        // ->where('tanggal_pengajuan','like',date('Y')."%")
        // ->count();
        // $total_pengajuan_cuti = pengajuan_cuti::where('tanggal_pengajuan','like',date('Y')."%")->count();
        $data['jumlah_karyawan'] = $jumlah_karyawan;
        // $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        // $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        return view('home_kepala_sub_bagian', $data);
    }

    private function index_direktur($request)
    {
        $role = Session('user')['divisi'];

        $jumlah_karyawan = Pegawai::where('jabatan_id', '!=', '1')->where('divisi_id', '=', $role)->count();
        // $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
        //     'status' => 'verifikasi'
        // ])
        // ->where('tanggal_pengajuan','like',date('Y')."%")
        // ->count();
        // $total_pengajuan_cuti = pengajuan_cuti::where('tanggal_pengajuan','like',date('Y')."%")->count();
        $data['jumlah_karyawan'] = $jumlah_karyawan;
        // $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        // $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        return view('home_direktur', $data);
    }


    private function index_admin($request)
    {
        $jumlah_karyawan = Pegawai::where('jabatan_id', '!=', '1')->count();
        $jumlah_staf_hr = Pegawai::where('jabatan_id', '=', '1')->count();
        // $pengajuan_cuti_verifikasi = pengajuan_cuti::where([
        //     'status' => 'verifikasi'
        // ])
        // ->where('tanggal_pengajuan','like',date('Y')."%")
        // ->count();
        // $total_pengajuan_cuti = pengajuan_cuti::
        // where('tanggal_pengajuan','like',date('Y')."%")
        // ->count();
        $data['jumlah_karyawan'] = $jumlah_karyawan;
        $data['jumlah_staf_hr'] = $jumlah_staf_hr;
        // $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        // $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        return view('home_admin', $data);
    }
}
