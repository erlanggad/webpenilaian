<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pengajuan_cuti_non;
use App\Models\Urgensi_Cuti;
use App\Models\View_sisa_cuti;
use Illuminate\Contracts\Session\Session;

class Cuti_non extends Controller
{
    public function index(Request $request)
    {
        $role = Session('user')['role'];
        switch ($role) {
            case 'karyawan':
                # code...
                return $this->index_karyawan($request);
                break;
            case 'Karyawan':
                # code...
                return $this->index_karyawan($request);
                break;
            case 'Manager':
                # code...
                return $this->index_pengelola($request);
                break;
            case 'admin':
                # code...
                return $this->index_pengelola($request);
                break;

            default:
                # code...
                return redirect('/login');
                break;
        }
    }

    public function index_pengelola($request){
        // $data['role'] = Session('user')['role'];
        // // $data['cuti_non'] = Pengajuan_cuti_non::join('karyawan','karyawan.id_karyawan','=','cuti_non.id_karyawan')->get();
        // // $data['cuti_non'] = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')->where('cuti_non.divisi_id', Session('user')['divisi'])->get();
        // // return view('pengajuan_cuti_non', $data);

        $data['role'] = Session('user')['role'];
        $id_divisi = Session('user')['id_divisi'];

        // Ambil bulan dari request
        if($data['role'] == 'Manager'){
        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
            ->where('cuti_non.divisi_id', Session('user')['divisi']);

        // Terapkan filter berdasarkan bulan jika dipilih
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        // Ambil data pengajuan cuti
        $data['cuti_non'] = $query->get();

        return view('pengajuan_cuti_non', $data);

    }else{
        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id');


        // Terapkan filter berdasarkan bulan jika dipilih
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        // Ambil data pengajuan cuti
        $data['cuti_non'] = $query->get();

        return view('pengajuan_cuti_non', $data);
    }
    }

    public function index_karyawan($request){
        $data['role'] = Session('user')['role'];
        $id_karyawan = Session('user')['id'];;
        // $data['cuti_non'] = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
        // ->where(['pegawai_id' => $id_karyawan])
        // ->get();

        // return view('pengajuan_cuti_non', $data);

        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
        ->where(['pegawai_id' => $id_karyawan]);

        // Terapkan filter berdasarkan bulan jika dipilih
        if ($bulan) {
            $query->whereMonth('tanggal_pengajuan', $bulan);
        }

        // Ambil data pengajuan cuti
        $data['cuti_non'] = $query->get();

        return view('pengajuan_cuti_non', $data);

    }

    public function create()
    {
        $urgensi_cuti = Urgensi_Cuti::all();

        return view('form_pengajuan_cuti_non', compact('urgensi_cuti'));
    }

    public function getUrgensiCuti($id){
        $urgensi_cuti = Urgensi_Cuti::find($id);

        if ($urgensi_cuti) {
            // Data ditemukan
            return response()->json([
                'success' => true,
                'data' => $urgensi_cuti
            ]);
        } else {
            // Data tidak ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

    }

    public function store(Request $request)
    {
        $id_karyawan = Session('user')['id'];
        $urgensiCuti = Urgensi_Cuti::where('id', $request->urgensi_cuti_id)->first();
        $sisaCuti = View_sisa_cuti::where('pegawai_id', $id_karyawan)->first();

        // dd($urgensiCuti->nama);
        $data = $request->all();
            // $data['pegawai_id'] = $id_karyawan;
            // // $data['urgensi_cuti_id'] = $request->urgensi_cuti_id;
            // $data['lama_cuti'] = $request->lama_cuti;
            // $urgensiCuti = Urgensi_Cuti::where('id', $request->urgensi_cuti_id)->first();
            // $data['keterangan'] = $urgensiCuti->nama;

            $simpan = Pengajuan_cuti_non::create($data);
            $simpan->pegawai_id = $id_karyawan;
            $simpan->urgensi_cuti_id = $request->urgensi_cuti_id;
            $simpan->lama_cuti = $request->lama_cuti;
            $simpan->keterangan = $urgensiCuti->nama;
            $simpan->divisi_id = $request->divisi_id;
            $simpan->sisa_cuti = $sisaCuti->sisa_cuti;
            if ($request->hasFile('image') ) {
               $request->file('image')->move('uploadnon/', $request->file('image')->getClientOriginalName());
               $simpan->image = $request->file('image')->getClientOriginalName();
               $simpan->save();
            }
            if ($request->hasFile('ttd_karyawan') ) {
                $request->file('ttd_karyawan')->move('uploadnon/', $request->file('ttd_karyawan')->getClientOriginalName());
                $simpan->ttd_karyawan = $request->file('ttd_karyawan')->getClientOriginalName();
                $simpan->save();
             }
            return redirect('/karyawan/cuti-non-tahunan')->with('success', 'Berhasil membuat pengajuan cuti');
    }

    public function edit(Request $request)
    {
        $data['cuti_non'] = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')->where([
            'id_cuti_non' => $request->segment(3)
        ])->first();
        return view('form_konfirmasi_pengajuan_non', $data);
    }

    public function update(Request $request)
    {
        $pengajuan_cuti = Pengajuan_cuti_non::where([
            'id_cuti_non' => $request->segment(3)
        ])->first();
        $data_sisa_cuti = View_sisa_cuti::where([
            'pegawai_id' => $pengajuan_cuti->pegawai_id
        ])->first();

        // dd($data_sisa_cuti);
        $nama = Session('user')['nama'];
        $jabatan = Session('user')['jabatan'];
        $ttd = Session('user')['image'];
        $pengajuan_cuti->status = $request->status;
        $pengajuan_cuti->verifikasi_oleh = $nama;
        $pengajuan_cuti->jabatan_verifikasi = $jabatan;
        $pengajuan_cuti->catatan = $request->catatan;
        $pengajuan_cuti->ttd = $ttd;
        // $pengajuan_cuti->sisa_cuti = $data_sisa_cuti->sisa_cuti - $pengajuan_cuti->lama_cuti;

        if ($pengajuan_cuti->save()) {
            // $data_sisa_cuti->sisa_cuti = $data_sisa_cuti->sisa_cuti - $pengajuan_cuti->lama_cuti;
            // $data_sisa_cuti->cuti_terpakai = $data_sisa_cuti->cuti_terpakai + $pengajuan_cuti->lama_cuti;
            // $data_sisa_cuti->save();
            return redirect('/pejabat-struktural/hasil-akhir-pengajuan-cuti/non-tahunan')->with('success', 'Berhasil memperbarui pengajuan cuti');
        } else {
            return redirect('/pejabat-struktural/hasil-akhir-pengajuan-cuti/non-tahunan')->with('failed', 'Gagal memperbarui pengajuan cuti');
        }
    }

    public function show(Request $request){

    }

    public function destroy(Request $request)
    {
        $pengajuan_cuti = Pengajuan_cuti_non::find($request->segment(3));
        if ($pengajuan_cuti->delete()) {
            return redirect(Session('user')['role'].'/cuti-non-tahunan')->with('success', 'Berhasil menghapus pengajuan cuti');
        } else {
            return redirect(Session('user')['role'].'/cuti-non-tahunan')->with('failed', 'Gagal menghapus pengajuan cuti');
        }
    }
}
