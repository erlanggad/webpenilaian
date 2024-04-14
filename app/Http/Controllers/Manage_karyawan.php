<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\models\Karyawan;
use App\Models\Konfig_cuti;
use App\Models\Pegawai;
use App\Models\View_sisa_cuti;

class Manage_karyawan extends Controller
{
    public function index()
    {
        $role = Session('user')['role'];

        if ($role == "Kepala Bagian") {
            $data['karyawan'] = Pegawai::join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->select('pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->where('pegawai.divisi_id', Session('user')['divisi'])->where('pegawai.jabatan_id', 4)->get();
        } elseif ($role == "Kepala Sub Bagian") {
            $data['karyawan'] = Pegawai::join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->select('pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->where('pegawai.divisi_id', Session('user')['divisi'])->where('pegawai.jabatan_id', 4)->get();
        } else {
            $data['karyawan'] = Pegawai::join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->select('pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->get();
        }
        // dd($data);
        return view('manage_karyawan', $data);
    }

    public function indexKepalaSubBagian()
    {
        $data['karyawan'] = Pegawai::join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->select('pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->where('pegawai.divisi_id', Session('user')['divisi'])->where('pegawai.jabatan_id', 3)->get();
        return view('manage_karyawan', $data);
    }

    public function create()
    {
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('form_karyawan', compact('divisi', 'jabatan'));
    }

    public function store(Request $request)
    {
        if (Pegawai::create($request->all())) {
            // $getPegawaiBaru = Pegawai::orderBy('created_at', 'desc')->first();
            // $getKonfigCuti = Konfig_cuti::where('tahun',(new \DateTime())->format('Y'))->first();

            // $sisa_cuti = new View_sisa_cuti;
            // $sisa_cuti->pegawai_id = $getPegawaiBaru->id;
            // $sisa_cuti->tahun = $getKonfigCuti->tahun;
            // $sisa_cuti->cuti_bersama = $getKonfigCuti->cuti_bersama;
            // $sisa_cuti->jumlah_cuti = $getKonfigCuti->jumlah_cuti;
            // $sisa_cuti->cuti_terpakai = 0;
            // $sisa_cuti->sisa_cuti = $getKonfigCuti->jumlah_cuti;
            // $sisa_cuti->save();

            return redirect(Session('user')['role'] . '/manage-karyawan')->with('success', 'Berhasil membuat karyawan');
        } else {
            return redirect(Session('user')['role'] . '/manage-karyawan')->with('failed', 'Gagal membuat karyawan');
        }
    }

    public function edit(Request $request)
    {
        // $data['karyawan'] = Pegawai::where([
        //     'id' => $request->segment(3)
        // ])->first();
        $karyawan = Pegawai::where([
            'id' => $request->segment(3)
        ])->first();
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('form_karyawan', compact('karyawan', 'divisi', 'jabatan'));
    }

    public function update(Request $request)
    {
        $karyawan = Pegawai::where([
            'id' => $request->segment(3)
        ])->first();
        // dd($request->image);
        $karyawan->nama_pegawai = $request->nama_karyawan;
        $karyawan->email = $request->email;
        $karyawan->nik = $request->nik;
        $karyawan->created_at = $request->tanggal_lahir;
        $karyawan->jabatan_id = $request->jabatan_id;
        $karyawan->divisi_id = $request->divisi_id;
        // $karyawan->image=$request->image;

        if ($karyawan->save()) {
            if ($request->hasFile('image')) {
                $request->file('image')->move('tanda_tangan/', $request->file('image')->getClientOriginalName());
                $karyawan->image = $request->file('image')->getClientOriginalName();
                $karyawan->save();
            }
            return redirect(Session('user')['role'] . '/manage-karyawan')->with('success', 'Berhasil memperbarui karyawan');
        } else {
            return redirect(Session('user')['role'] . '/manage-karyawan')->with('failed', 'Gagal memperbarui karyawan');
        }
    }

    public function show()
    {
    }

    public function destroy(Request $request, $id)
    {
        $karyawan = Pegawai::findOrFail($id);



        if ($karyawan->delete()) {
            $sisacuti = View_sisa_cuti::where('pegawai_id', $id)->first();
            $sisacuti->delete();
            return redirect(Session('user')['role'] . '/manage-karyawan')->with('success', 'Berhasil menghapus karyawan');
        } else {
            return redirect(Session('user')['role'] . '/manage-karyawan')->with('failed', 'Gagal menghapus karyawan');
        }
    }
}
