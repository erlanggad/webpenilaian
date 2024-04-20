<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\models\Pengajuan_cuti_non;
use App\Models\Penilaian;
use App\Models\Urgensi_Cuti;
use App\Models\View_sisa_cuti;
use Illuminate\Contracts\Session\Session;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->tahun);
        $perhitunganMooraController = new PerhitunganMooraController();
        $moora = $perhitunganMooraController->data_hasil_akhir($request->jabatan, $request->tahun, '');

        $perhitunganWaspasController = new PerhitunganWaspasController();
        $waspas = $perhitunganWaspasController->data_hasil_akhir($request->jabatan, $request->tahun, '');

        $perhitunganTopsisController = new PerhitunganTopsisController();
        $topsis = $perhitunganTopsisController->data_hasil_akhir($request->jabatan, $request->tahun, '');

        $data['topsis'] = $topsis;
        $data['waspas'] = $waspas;
        $data['moora'] = $moora;

        // dd($data);
        return view('ranking_penilaian', $data);
    }

    public function index_penilaian_karyawan($request)
    {
        // $data['role'] = Session('user')['role'];
        // // $data['cuti_non'] = Pengajuan_cuti_non::join('karyawan','karyawan.id_karyawan','=','cuti_non.id_karyawan')->get();
        // // $data['cuti_non'] = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')->where('cuti_non.divisi_id', Session('user')['divisi'])->get();
        // // return view('pengajuan_cuti_non', $data);

        $data['role'] = Session('user')['role'];
        $id_divisi = Session('user')['id_divisi'];

        // Ambil bulan dari request
        if ($data['role'] == 'Kepala Sub Bagian') {
            // $bulan = $request->input('bulan');

            // Buat query untuk pengajuan cuti
            $query = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 4);

            // Terapkan filter berdasarkan bulan jika dipilih
            // if ($bulan) {
            //     $query->whereMonth('tanggal_pengajuan', $bulan);
            // }

            // Ambil data pengajuan cuti
            $data['penilaian'] = $query->get();
            $data['kriteria'] = Criteria::all();


            // dd($data);

            return view('penilaian', $data);
        } else {
            $bulan = $request->input('bulan');

            // Buat query untuk pengajuan cuti
            $query = Pengajuan_cuti_non::join('pegawai', 'pegawai.id', '=', 'cuti_non.pegawai_id')->join('urgensi_cuti', 'urgensi_cuti.id', '=', 'cuti_non.urgensi_cuti_id');


            // Terapkan filter berdasarkan bulan jika dipilih
            if ($bulan) {
                $query->whereMonth('tanggal_pengajuan', $bulan);
            }

            // Ambil data pengajuan cuti
            $data['cuti_non'] = $query->get();

            return view('pengajuan_cuti_non', $data);
        }
    }

    public function index_karyawan($request)
    {
        $data['role'] = Session('user')['role'];
        $id_karyawan = Session('user')['id'];;
        // $data['cuti_non'] = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
        // ->where(['pegawai_id' => $id_karyawan])
        // ->get();

        // return view('pengajuan_cuti_non', $data);

        $bulan = $request->input('bulan');

        // Buat query untuk pengajuan cuti
        $query = Pengajuan_cuti_non::join('pegawai', 'pegawai.id', '=', 'cuti_non.pegawai_id')
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
        $pegawai = Pegawai::join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->select('pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->where('pegawai.divisi_id', Session('user')['divisi'])->where('pegawai.jabatan_id', 4)->get();
        $criteria = Criteria::all();
        return view('form_penilaian', compact('pegawai', 'criteria'));
    }

    public function getUrgensiCuti($id)
    {
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
        // $data = $request->all();
        // dd($request->all());
        // $simpan = Penilaian::create();
        // $simpan->pegawai_id = 6;
        // $simpan->c1 = $request->C1;
        // $simpan->c2 = $request->C2;
        // $simpan->c3 = $request->C3;
        // $simpan->c4 = $request->C4;
        // $simpan->c5 = $request->C5;
        // $simpan->c5 = $request->C5;
        // $simpan->c6 = $request->C6;
        // $simpan->c7 = $request->C7;
        // $simpan->c8 = $request->C8;
        // // dd($simpan);

        // $simpan->save();

        Penilaian::create([
            'pegawai_id' => $request->pegawai_id,
            'c1' => $request->C1,
            'c2' => $request->C2,
            'c3' => $request->C3,
            'c4' => $request->C4,
            'c5' => $request->C5,
            'c6' => $request->C6,
            'c7' => $request->C7,
            'c8' => $request->C8,
        ]);


        return redirect('/kepala-sub-bagian/form-penilaian/')->with('success', 'Berhasil membuat pengajuan cuti');
    }

    public function edit(Request $request)
    {
        $penilaian = Penilaian::where([
            'id' => $request->segment(3)
        ])->first();

        $pegawai = Pegawai::join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->select('pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->where('pegawai.divisi_id', Session('user')['divisi'])->where('pegawai.jabatan_id', 4)->get();
        $criteria = Criteria::all();
        // $divisi = Divisi::all();
        // $jabatan = Jabatan::all();
        return view('form_penilaian', compact('pegawai', 'penilaian', 'criteria'));
    }

    public function update(Request $request)
    {
        $penilaian = Penilaian::where([
            'id' => $request->segment(3)
        ])->first();
        // $data_sisa_cuti = View_sisa_cuti::where([
        //     'pegawai_id' => $pengajuan_cuti->pegawai_id
        // ])->first();

        // dd($data_sisa_cuti);

        $penilaian->pegawai_id = 6;
        $penilaian->c1 = $request->C1;
        $penilaian->c2 = $request->C2;
        $penilaian->c3 = $request->C3;
        $penilaian->c4 = $request->C4;
        $penilaian->c5 = $request->C5;
        $penilaian->c5 = $request->C5;
        $penilaian->c6 = $request->C6;
        $penilaian->c7 = $request->C7;
        $penilaian->c8 = $request->C8;
        // $pengajuan_cuti->sisa_cuti = $data_sisa_cuti->sisa_cuti - $pengajuan_cuti->lama_cuti;

        if ($penilaian->save()) {
            // $data_sisa_cuti->sisa_cuti = $data_sisa_cuti->sisa_cuti - $pengajuan_cuti->lama_cuti;
            // $data_sisa_cuti->cuti_terpakai = $data_sisa_cuti->cuti_terpakai + $pengajuan_cuti->lama_cuti;
            // $data_sisa_cuti->save();
            return redirect('/kepala-sub-bagian/form-penilaian/')->with('success', 'Berhasil memperbarui pengajuan cuti');
        } else {
            return redirect('/kepala-sub-bagian/form-penilaian/')->with('failed', 'Gagal memperbarui pengajuan cuti');
        }
    }

    public function show(Request $request)
    {
    }

    public function destroy(Request $request)
    {
        $pengajuan_cuti = Penilaian::find($request->segment(3));
        // dd($pengajuan_cuti);
        if ($pengajuan_cuti->delete()) {
            return redirect('/kepala-sub-bagian/form-penilaian')->with('success', 'Berhasil menghapus pengajuan cuti');
        } else {
            return redirect('/kepala-sub-bagian/form-penilaian')->with('failed', 'Gagal menghapus pengajuan cuti');
        }
    }
}
