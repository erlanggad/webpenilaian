<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pengajuan_cuti;
use App\models\View_sisa_cuti;
use App\models\DIvisi;

class Manage_pengajuan_cuti extends Controller
{
    public function index(Request $request)
    {
        $role = Session('user')['role'];
        switch ($role) {
            case 'karyawan':
                # code...
                return $this->index_karyawan($request);
                break;

            // case 'Karyawan':
            //     # code...
            //     return $this->index_karyawan($request);
            //     break;
            case 'Manager':
                # code...
                return $this->index_pengelolaa($request);
                break;
            case 'admin':
                # code...
                return $this->index_pengelolaa($request);
                break;

            default:
                # code...
                return redirect('/login');
                break;
        }
    }

    public function index_pengelola($request){
        $data['role'] = Session('user')['role'];
        $data['pengajuan_cuti'] = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')->join('urgensi_cuti', 'urgensi_cuti.id','=','pengajuan_cuti.urgensi_cuti_id')->where('pengajuan_cuti.divisi_id', Session('user')['divisi'])->get();
        // dd($data)
        return view('manage_pengajuan_cuti', $data);
    }
    public function index_pengelolaa(Request $request) {
         // $data['role'] = Session('user')['role'];
        // $id_divisi = Session('user')['id_divisi'];
        // // $data['pengajuan_cuti'] = Pengajuan_cuti::join('karyawan','karyawan.id_karyawan','=','pengajuan_cuti.id_karyawan')
        // // ->first();
        // $data['pengajuan_cuti'] = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')->where('pengajuan_cuti.divisi_id', Session('user')['divisi'])->get();
        // // ->get();
        // return view('manage_pengajuan_cuti', $data);
        $data['role'] = Session('user')['role'];
        $id_divisi = Session('user')['id_divisi'];

        // Ambil bulan dari request
        if($data['role'] == 'Manager'){
        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti::join('pegawai', 'pegawai.id', '=', 'pengajuan_cuti.pegawai_id')
            ->where('pengajuan_cuti.divisi_id', Session('user')['divisi']);

        // Terapkan filter berdasarkan bulan jika dipilih
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        // Ambil data pengajuan cuti
        $data['pengajuan_cuti'] = $query->get();

        return view('manage_pengajuan_cuti', $data);
    }else{
        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti::join('pegawai', 'pegawai.id', '=', 'pengajuan_cuti.pegawai_id');


        // Terapkan filter berdasarkan bulan jika dipilih
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        // Ambil data pengajuan cuti
        $data['pengajuan_cuti'] = $query->get();

        return view('manage_pengajuan_cuti', $data);
    }
    }

    public function index_karyawan(Request $request){
              $data['role'] = Session('user')['role'];
        $id_karyawan = Session('user')['id'];

        // Ambil bulan dari request
        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti::join('pegawai', 'pegawai.id', '=', 'pengajuan_cuti.pegawai_id')
            ->where('pengajuan_cuti.pegawai_id', $id_karyawan);

        // Terapkan filter berdasarkan bulan jika dipilih
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        // Ambil data pengajuan cuti
        $data['pengajuan_cuti'] = $query->get();

        return view('manage_pengajuan_cuti', $data);

        // return view('manage_pengajuan_cuti', $data);
    }

    public function create()
    {

        return view('form_pengajuan_cuti');
    }

    public function store(Request $request)
    {
        $id_karyawan = Session('user')['id'];
        $sisa_cuti = View_sisa_cuti::where([
            'pegawai_id' => $id_karyawan,
        ])->first();
        $sisaCuti = View_sisa_cuti::where('pegawai_id', $id_karyawan)->first();

        if($sisa_cuti->sisa_cuti >= $request->lama_cuti) {
            $data = $request->all();
            // $data['pegawai_id'] = $id_karyawan;
            $simpan = Pengajuan_cuti::create($data);
            $simpan->pegawai_id = $id_karyawan;
            // $simpan->urgensi_cuti_id = $request->urgensi_cuti_id;
            $simpan->lama_cuti = $request->lama_cuti;
            $simpan->keterangan = $request->keterangan;
            $simpan->divisi_id = $request->divisi_id;
            $simpan->sisa_cuti = $sisaCuti->sisa_cuti;
            if ($request->hasFile('ttd_karyawan')) {
               $request->file('ttd_karyawan')->move('ttd_karyawan/', $request->file('ttd_karyawan')->getClientOriginalName());
               $simpan->ttd_karyawan = $request->file('ttd_karyawan')->getClientOriginalName();
               $simpan->save();
            }
            if ($simpan) {
                return redirect(Session('user')['role'].'/manage-pengajuan-cuti')->with('success', 'Berhasil membuat pengajuan cuti');
            } else {
                return redirect(Session('user')['role'].'/manage-pengajuan-cuti')->with('failed', 'Gagal membuat pengajuan cuti');
            }
        } else {
            return redirect(Session('user')['role'].'/manage-pengajuan-cuti')->with('failed', 'Gagal, sisa cuti tidak mencukupi');
        }
    }

    public function edit(Request $request)
    {
        $data['pengajuan_cuti'] = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')->where([
            'id_pengajuan_cuti' => $request->segment(3)
        ])->first();
        return view('form_konfirmasi_pengajuan', $data);
    }
    public function update(Request $request)
    {
        $pengajuan_cuti = Pengajuan_cuti::where([
            'id_pengajuan_cuti' => $request->segment(3)
        ])->first();
        $data_sisa_cuti = View_sisa_cuti::where([
            'pegawai_id' => $pengajuan_cuti->pegawai_id
        ])->first();

        // dd($pengajuan_cuti);
        $nama = Session('user')['nama'];
        $jabatan = Session('user')['role'];
        // $image=Session('user')['image'];
        $pengajuan_cuti->status = $request->status;
        $pengajuan_cuti->verifikasi_oleh = $nama;
        $pengajuan_cuti->jabatan_verifikasi = $jabatan;
        $pengajuan_cuti->catatan = $request->catatan;
        if($request->status == "disetujui"){

        $pengajuan_cuti->sisa_cuti = $data_sisa_cuti->sisa_cuti - $pengajuan_cuti->lama_cuti;
        // $pengajuan_cuti->image = $image;
        if ($pengajuan_cuti->save()) {
            $data_sisa_cuti->sisa_cuti = $data_sisa_cuti->sisa_cuti - $pengajuan_cuti->lama_cuti;
            $data_sisa_cuti->cuti_terpakai = $data_sisa_cuti->cuti_terpakai + $pengajuan_cuti->lama_cuti;
            $data_sisa_cuti->save();

            return redirect('/pejabat-struktural/manage-pengajuan-cuti')->with('success', 'Berhasil memperbarui pengajuan cuti');
        } else {
            return redirect('/pejabat-struktural/manage-pengajuan-cuti')->with('failed', 'Gagal memperbarui pengajuan cuti');
        }
    }else{
        if ($pengajuan_cuti->save()) {


            return redirect('/pejabat-struktural/manage-pengajuan-cuti')->with('success', 'Berhasil memperbarui pengajuan cuti');
        } else {
            return redirect('/pejabat-struktural/manage-pengajuan-cuti')->with('failed', 'Gagal memperbarui pengajuan cuti');
        }
    }
    }

    public function show(Request $request)
    {
        $p['pengajuan_cuti'] = Pengajuan_cuti::join('karyawan','karyawan.id_karyawan','=','pengajuan_cuti.id_karyawan')->where([
            'id_pengajuan_cuti' => $request->segment(3)
        ])->first();
        return view('form_konfirmasi_pengajuan', $p);
    }
    public function print(){

    }
    public function destroy(Request $request)
    {
        $pengajuan_cuti = Pengajuan_cuti::find($request->segment(3));
        if ($pengajuan_cuti->delete()) {
            return redirect(Session('user')['role'].'/manage-pengajuan-cuti')->with('success', 'Berhasil menghapus pengajuan cuti');
        } else {
            return redirect(Session('user')['role'].'/manage-pengajuan-cuti')->with('failed', 'Gagal menghapus pengajuan cuti');
        }
    }
}
