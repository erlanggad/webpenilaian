<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\models\Pengajuan_cuti_non;
use App\Models\Penilaian;

class Print_penilaian extends Controller
{
    public function show(Request $request)
    {
        $data['penilaian'] = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')->join('divisi', 'divisi.id', '=', 'pegawai.divisi_id')->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan_id')->where([
            'penilaian.id' => $request->id
        ])->select('penilaian.*', 'pegawai.*', 'divisi.nama as nama_divisi', 'jabatan.nama as nama_jabatan')->first();
        // dd($data['penilaian']);
        if (Session('user')['role'] === "Kepala Sub Bagian") {
            $data['atasan'] = Pegawai::where('divisi_id', '=', $data['penilaian']->divisi_id)->where('jabatan_id', '=', '2')->first();
        } else {
            $data['atasan'] = Pegawai::where('divisi_id', '=', $data['penilaian']->divisi_id)->where('jabatan_id', '=', '3')->first();
        }
        $data['direktur'] = Pegawai::where('jabatan_id', '=', '1')->select('pegawai.nama_pegawai')->first();
        $data['criteria'] = Criteria::all();
        // Hitung total nilai c1 sampai c8
        $totalNilai = $data['penilaian']->c1 + $data['penilaian']->c2 + $data['penilaian']->c3 + $data['penilaian']->c4 +
            $data['penilaian']->c5 + $data['penilaian']->c6 + $data['penilaian']->c7 + $data['penilaian']->c8;

        // Hitung rata-rata nilai c1 sampai c8
        $rataNilai = $totalNilai / 8;
        $data['totalNilai'] = $totalNilai;
        $data['rataNilai'] = $rataNilai;

        $perhitunganWaspasController = new PerhitunganWaspasController();

        $waspas = $perhitunganWaspasController->data_hasil_akhir($request->jabatan, $request->tahun, 'individu');

        $perhitunganTopsisController = new PerhitunganTopsisController();

        $topsis = $perhitunganTopsisController->data_hasil_akhir($request->jabatan, $request->tahun, 'individu');

        $perhitunganMooraController = new PerhitunganMooraController();
        $moora = $perhitunganMooraController->data_hasil_akhir($request->jabatan, $request->tahun, 'individu');
        // dd($moora);
        // Ambil id user dari data penilaian
        $userId = $data['penilaian']->id;

        // Filter array waspas untuk mendapatkan data dengan id yang sama dengan id user
        $userWaspasData = array_filter($waspas, function ($item) use ($userId) {
            return $item['id'] == $userId;
        });
        $userTopsisData = array_filter($topsis, function ($item) use ($userId) {
            return $item['id'] == $userId;
        });
        $userMooraData = array_filter($moora, function ($item) use ($userId) {
            return $item['id'] == $userId;
        });

        // Ambil data yang pertama karena kita hanya mengharapkan satu hasil
        $data['userWaspas'] = reset($userWaspasData);
        $data['userTopsis'] = reset($userTopsisData);
        $data['userMoora'] = reset($userMooraData);

        // Sekarang Anda dapat mengakses data waspas untuk user yang sesuai dengan id
        // dd($data);

        // dd($data['userTopsis']);
        // Contoh akses data:
        // echo "Nama: " . $userWaspas['nama'] . "<br>";
        // echo "Skor Akhir: " . $userWaspas['skor_akhir'] . "<br>";
        // echo "Sum Q1: " . $userWaspas['sum q1'] . "<br>";
        // dan seterusnya...

        return view('print_penilaian', $data);
    }
}
