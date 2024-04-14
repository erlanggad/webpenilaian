<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Pengajuan_cuti;
use App\Models\Pengajuan_cuti_non;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PerhitunganWaspasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($jenis);

        if (Session('user')['role'] === "Kepala Bagian") {
            $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 3)
                ->get();
        } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
            $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 4)
                ->get();
        }

        $kriteria = Criteria::all();

        // dd($penilaian);

        $data['penilaian'] = $penilaian;
        $data['kriteria'] = $kriteria;

        return view('konversi_penilaian', ['data' => $data]);
    }

    public function normalisasi()
    {

        if (Session('user')['role'] === "Kepala Bagian") {
            $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 3)
                ->get();
        } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
            $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 4)
                ->get();
        }


        $max_c1 = -INF; // Inisialisasi nilai maksimum untuk c1
        $max_c2 = -INF; // Inisialisasi nilai maksimum untuk c2
        $max_c3 = -INF; // Inisialisasi nilai maksimum untuk c3
        $max_c4 = -INF; // Inisialisasi nilai maksimum untuk c4
        $max_c5 = -INF; // Inisialisasi nilai maksimum untuk c5
        $max_c6 = -INF; // Inisialisasi nilai maksimum untuk c6
        $max_c7 = -INF; // Inisialisasi nilai maksimum untuk c7
        $max_c8 = -INF; // Inisialisasi nilai maksimum untuk c8

        $normalisasi = [];

        foreach ($penilaian as $item) {
            // Update nilai maksimum untuk setiap kriteria
            $max_c1 = max($max_c1, $item->c1);
            $max_c2 = max($max_c2, $item->c2);
            $max_c3 = max($max_c3, $item->c3);
            $max_c4 = max($max_c4, $item->c4);
            $max_c5 = max($max_c5, $item->c5);
            $max_c6 = max($max_c6, $item->c6);
            $max_c7 = max($max_c7, $item->c7);
            $max_c8 = max($max_c8, $item->c8);




            // dd($item->c1);
        }

        foreach ($penilaian as $item) {
            // Menghitung nilai $Rij_satu sampai $Rij_empat
            $Rij_satu = $item->c1 / $max_c1;
            $Rij_dua = $item->c2 / $max_c2;
            $Rij_tiga = $item->c3 / $max_c3;
            $Rij_empat = $item->c4 / $max_c4;
            $Rij_lima = $item->c5 / $max_c5;
            $Rij_enam = $item->c6 / $max_c6;
            $Rij_tujuh = $item->c7 / $max_c7;
            $Rij_delapan = $item->c8 / $max_c8;

            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                'Rij_satu' => number_format($Rij_satu, 3),
                'Rij_dua' => number_format($Rij_dua, 3),
                'Rij_tiga' => number_format($Rij_tiga, 3),
                'Rij_empat' => number_format($Rij_empat, 3),
                'Rij_lima' => number_format($Rij_lima, 3),
                'Rij_enam' => number_format($Rij_enam, 3),
                'Rij_tujuh' => number_format($Rij_tujuh, 3),
                'Rij_delapan' => number_format($Rij_delapan, 3)
            ];
        }
        // dd($max_c1);

        // dd($normalisasi);




        return view('normalisasi_penilaian_waspas', ['data' => $normalisasi]);
    }

    public function hasil_akhir()
    {


        if (Session('user')['role'] === "Kepala Bagian") {
            $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 3)
                ->get();
        } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
            $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', Session('user')['divisi'])
                ->where('pegawai.jabatan_id', 4)
                ->get();
        }


        $max_c1 = -INF; // Inisialisasi nilai maksimum untuk c1
        $max_c2 = -INF; // Inisialisasi nilai maksimum untuk c2
        $max_c3 = -INF; // Inisialisasi nilai maksimum untuk c3
        $max_c4 = -INF; // Inisialisasi nilai maksimum untuk c4
        $max_c5 = -INF; // Inisialisasi nilai maksimum untuk c5
        $max_c6 = -INF; // Inisialisasi nilai maksimum untuk c6
        $max_c7 = -INF; // Inisialisasi nilai maksimum untuk c7
        $max_c8 = -INF; // Inisialisasi nilai maksimum untuk c8

        $normalisasi = [];

        foreach ($penilaian as $item) {
            // Update nilai maksimum untuk setiap kriteria
            $max_c1 = max($max_c1, $item->c1);
            $max_c2 = max($max_c2, $item->c2);
            $max_c3 = max($max_c3, $item->c3);
            $max_c4 = max($max_c4, $item->c4);
            $max_c5 = max($max_c5, $item->c5);
            $max_c6 = max($max_c6, $item->c6);
            $max_c7 = max($max_c7, $item->c7);
            $max_c8 = max($max_c8, $item->c8);




            // dd($item->c1);
        }

        foreach ($penilaian as $item) {
            // Menghitung nilai $Rij_satu sampai $Rij_empat
            $Rij_satu = $item->c1 / $max_c1;
            $Rij_dua = $item->c2 / $max_c2;
            $Rij_tiga = $item->c3 / $max_c3;
            $Rij_empat = $item->c4 / $max_c4;
            $Rij_lima = $item->c5 / $max_c5;
            $Rij_enam = $item->c6 / $max_c6;
            $Rij_tujuh = $item->c7 / $max_c7;
            $Rij_delapan = $item->c8 / $max_c8;

            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                'Rij_satu' => number_format($Rij_satu, 3),
                'Rij_dua' => number_format($Rij_dua, 3),
                'Rij_tiga' => number_format($Rij_tiga, 3),
                'Rij_empat' => number_format($Rij_empat, 3),
                'Rij_lima' => number_format($Rij_lima, 3),
                'Rij_enam' => number_format($Rij_enam, 3),
                'Rij_tujuh' => number_format($Rij_tujuh, 3),
                'Rij_delapan' => number_format($Rij_delapan, 3)
            ];
        }

        $hasil_akhir = [];
        $kriteria = Criteria::all();
        // Akses nilai kolom 'criteria' dari objek $kriteria
        // $nilai_criteria = $kriteria->pluck('criteria');

        // dd($normalisasi);

        foreach ($normalisasi as $item2) {
            $nilai_criteria = $kriteria->pluck('weight');
            // dd($nilai_criteria[1]);

            $nilai = (0.5 * ($item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7])) +
                (0.5 * (pow($item2['Rij_satu'], $nilai_criteria[0]) * pow($item2['Rij_dua'], $nilai_criteria[1]) * pow($item2['Rij_tiga'], $nilai_criteria[2]) * pow($item2['Rij_empat'], $nilai_criteria[3]) * pow($item2['Rij_lima'], $nilai_criteria[4]) * pow($item2['Rij_enam'], $nilai_criteria[5]) * pow($item2['Rij_tujuh'], $nilai_criteria[6]) * pow($item2['Rij_delapan'], $nilai_criteria[7])));

            $q1 = (0.5 * ($item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7]));

            $q2 = (0.5 * (pow($item2['Rij_satu'], $nilai_criteria[0]) * pow($item2['Rij_dua'], $nilai_criteria[1]) * pow($item2['Rij_tiga'], $nilai_criteria[2]) * pow($item2['Rij_empat'], $nilai_criteria[3]) * pow($item2['Rij_lima'], $nilai_criteria[4]) * pow($item2['Rij_enam'], $nilai_criteria[5]) * pow($item2['Rij_tujuh'], $nilai_criteria[6]) * pow($item2['Rij_delapan'], $nilai_criteria[7])));
            $hasil_akhir[] = [
                // 'id_cuti_non' => $item2['id_cuti_non'],
                'nama' => $item2['nama_pegawai'],
                'skor_akhir' => number_format($nilai, 4),
                'sum q1' => $item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7],

                'q1' => $q1,
                'q2' => number_format($q2, 3),
                'row 1' => number_format(($item2['Rij_satu'] * $nilai_criteria[0]), 3),
                'row 2' => number_format(($item2['Rij_dua'] * $nilai_criteria[1]), 3),
                'row 3' => number_format(($item2['Rij_tiga'] * $nilai_criteria[2]), 3),
                'row 4' => number_format(($item2['Rij_empat'] * $nilai_criteria[3]), 3),
                'row 5' => number_format(($item2['Rij_lima'] * $nilai_criteria[4]), 3),
                'row 6' => number_format(($item2['Rij_enam'] * $nilai_criteria[5]), 3),
                'row 7' => number_format(($item2['Rij_tujuh'] * $nilai_criteria[6]), 3),
                'row 8' => number_format(($item2['Rij_delapan'] * $nilai_criteria[7]), 3),

            ];
        }

        // Menghitung nilai hasil akhir seperti sebelumnya
        //     $hasil_akhir = [];

        //     foreach ($normalisasi as $item2) {
        //         $nilai = (0.5 * ($item2['Rij_satu'] * 0.4 + $item2['Rij_dua'] * 0.3 + $item2['Rij_tiga'] * 0.2 + $item2['Rij_empat'] * 0.1)) +
        //             (0.5 * (pow($item2['Rij_satu'], 0.4) * pow($item2['Rij_dua'], 0.3) * pow($item2['Rij_tiga'], 0.2) * pow($item2['Rij_empat'], 0.1)));



        //     // Mengurutkan nilai hasil akhir dari yang tertinggi ke yang terendah
        //     usort($hasil_akhir, function ($a, $b) {
        //         return $b['skor_akhir'] <=> $a['skor_akhir'];
        //     });
        // }

        // // dd($data);
        // // dd($normalisasi);
        // $role['role'] = Session('user')['role'];
        // dd($hasil_akhir);
        return view('hasil_akhir_waspas', ['data' => $hasil_akhir]);
        // } else {

        //     $hasil_akhir = [];

        //     $role['role'] = Session('user')['role'];

        //     return view('hasil_akhir_pengajuan_cuti_non', ['data' => $hasil_akhir, 'role' => $role]);
        // }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}
