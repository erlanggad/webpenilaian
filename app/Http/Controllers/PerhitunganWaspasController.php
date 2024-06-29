<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\DetailPenilaian;
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
        $role = session('user')['role'];
        $divisiId = session('user')['divisi'];
        $periode = 2024; // Sesuaikan dengan periode yang diinginkan

        if ($role === "Kepala Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 3)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        } elseif ($role === "Kepala Sub Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 4)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        }

        $kriteria = Criteria::all();

        $data['penilaian'] = $penilaian;
        $data['kriteria'] = $kriteria;

        // dd($data);

        return view('konversi_penilaian', $data);
    }


    // public function normalisasi()
    // {

    //     if (Session('user')['role'] === "Kepala Bagian") {
    //         $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
    //             ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
    //             ->where('pegawai.divisi_id', Session('user')['divisi'])
    //             ->where('pegawai.jabatan_id', 3)
    //             ->where('periode', 2024)

    //             ->get();
    //     } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
    //         $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
    //             ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
    //             ->where('pegawai.divisi_id', Session('user')['divisi'])
    //             ->where('pegawai.jabatan_id', 4)
    //             ->where('periode', 2024)
    //             ->get();
    //     }


    //     $max_c1 = -INF; // Inisialisasi nilai maksimum untuk c1
    //     $max_c2 = -INF; // Inisialisasi nilai maksimum untuk c2
    //     $max_c3 = -INF; // Inisialisasi nilai maksimum untuk c3
    //     $max_c4 = -INF; // Inisialisasi nilai maksimum untuk c4
    //     $max_c5 = -INF; // Inisialisasi nilai maksimum untuk c5
    //     $max_c6 = -INF; // Inisialisasi nilai maksimum untuk c6
    //     $max_c7 = -INF; // Inisialisasi nilai maksimum untuk c7
    //     $max_c8 = -INF; // Inisialisasi nilai maksimum untuk c8

    //     $normalisasi = [];

    //     foreach ($penilaian as $item) {
    //         // Update nilai maksimum untuk setiap kriteria
    //         $max_c1 = max($max_c1, $item->c1);
    //         $max_c2 = max($max_c2, $item->c2);
    //         $max_c3 = max($max_c3, $item->c3);
    //         $max_c4 = max($max_c4, $item->c4);
    //         $max_c5 = max($max_c5, $item->c5);
    //         $max_c6 = max($max_c6, $item->c6);
    //         $max_c7 = max($max_c7, $item->c7);
    //         $max_c8 = max($max_c8, $item->c8);




    //         // dd($item->c1);
    //     }

    //     foreach ($penilaian as $item) {
    //         // Menghitung nilai $Rij_satu sampai $Rij_empat
    //         $Rij_satu = $item->c1 / $max_c1;
    //         $Rij_dua = $item->c2 / $max_c2;
    //         $Rij_tiga = $item->c3 / $max_c3;
    //         $Rij_empat = $item->c4 / $max_c4;
    //         $Rij_lima = $item->c5 / $max_c5;
    //         $Rij_enam = $item->c6 / $max_c6;
    //         $Rij_tujuh = $item->c7 / $max_c7;
    //         $Rij_delapan = $item->c8 / $max_c8;

    //         $normalisasi[] = [
    //             'nama_pegawai' => $item['nama_pegawai'],
    //             'Rij_satu' => number_format($Rij_satu, 3),
    //             'Rij_dua' => number_format($Rij_dua, 3),
    //             'Rij_tiga' => number_format($Rij_tiga, 3),
    //             'Rij_empat' => number_format($Rij_empat, 3),
    //             'Rij_lima' => number_format($Rij_lima, 3),
    //             'Rij_enam' => number_format($Rij_enam, 3),
    //             'Rij_tujuh' => number_format($Rij_tujuh, 3),
    //             'Rij_delapan' => number_format($Rij_delapan, 3)
    //         ];
    //     }
    //     // dd($max_c1);

    //     dd($normalisasi);




    //     return view('normalisasi_penilaian_waspas', ['data' => $normalisasi]);
    // }

    public function normalisasi()
    {
        // Ambil semua kriteria
        $kriteria = Criteria::all();

        // Ambil data penilaian dari tabel detail_penilaian
        $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
            ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
            ->where('pegawai.divisi_id', Session('user')['divisi'])
            ->whereIn('pegawai.jabatan_id', [3, 4])
            ->where('detail_penilaian.periode', 2024)
            ->get();

        // Menghitung nilai maksimum untuk setiap kriteria
        $max_values = [];
        foreach ($kriteria as $k) {
            $max_values[$k->id] = DetailPenilaian::where('criteria_id', $k->id)
                ->where('periode', 2024)
                ->max('nilai');
        }

        // Memproses normalisasi untuk setiap karyawan
        $normalisasi = [];
        foreach ($penilaian as $item) {
            if (!isset($normalisasi[$item->pegawai_id])) {
                $normalisasi[$item->pegawai_id] = [
                    'nama_pegawai' => $item->nama_pegawai,
                    'Rij' => [],
                ];
            }

            $criteria_name = $kriteria->where('id', $item->criteria_id)->first()->criteria;
            $max_value = $max_values[$item->criteria_id];
            // Menghitung nilai normalisasi Rij untuk kriteria saat ini
            $Rij = ($item->nilai / $max_value);
            $normalisasi[$item->pegawai_id]['Rij'][$criteria_name] = $Rij;
        }

        // Ubah format array untuk kebutuhan view
        $normalisasi = array_values($normalisasi);


        // dd($normalisasi);
        return view('normalisasi_penilaian_waspas', compact('normalisasi', 'kriteria'));
    }


    // public function hasil_akhir()
    // {


    //     if (Session('user')['role'] === "Kepala Bagian") {
    //         $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
    //             ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
    //             ->where('pegawai.divisi_id', Session('user')['divisi'])
    //             ->where('pegawai.jabatan_id', 3)
    //             ->where('periode', 2024)

    //             ->get();
    //     } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
    //         $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
    //             ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
    //             ->where('pegawai.divisi_id', Session('user')['divisi'])
    //             ->where('pegawai.jabatan_id', 4)
    //             ->where('periode', 2024)
    //             ->get();
    //     }


    //     $max_c1 = -INF; // Inisialisasi nilai maksimum untuk c1
    //     $max_c2 = -INF; // Inisialisasi nilai maksimum untuk c2
    //     $max_c3 = -INF; // Inisialisasi nilai maksimum untuk c3
    //     $max_c4 = -INF; // Inisialisasi nilai maksimum untuk c4
    //     $max_c5 = -INF; // Inisialisasi nilai maksimum untuk c5
    //     $max_c6 = -INF; // Inisialisasi nilai maksimum untuk c6
    //     $max_c7 = -INF; // Inisialisasi nilai maksimum untuk c7
    //     $max_c8 = -INF; // Inisialisasi nilai maksimum untuk c8

    //     $normalisasi = [];

    //     foreach ($penilaian as $item) {
    //         // Update nilai maksimum untuk setiap kriteria
    //         $max_c1 = max($max_c1, $item->c1);
    //         $max_c2 = max($max_c2, $item->c2);
    //         $max_c3 = max($max_c3, $item->c3);
    //         $max_c4 = max($max_c4, $item->c4);
    //         $max_c5 = max($max_c5, $item->c5);
    //         $max_c6 = max($max_c6, $item->c6);
    //         $max_c7 = max($max_c7, $item->c7);
    //         $max_c8 = max($max_c8, $item->c8);




    //         // dd($item->c1);
    //     }

    //     foreach ($penilaian as $item) {
    //         // Menghitung nilai $Rij_satu sampai $Rij_empat
    //         $Rij_satu = $item->c1 / $max_c1;
    //         $Rij_dua = $item->c2 / $max_c2;
    //         $Rij_tiga = $item->c3 / $max_c3;
    //         $Rij_empat = $item->c4 / $max_c4;
    //         $Rij_lima = $item->c5 / $max_c5;
    //         $Rij_enam = $item->c6 / $max_c6;
    //         $Rij_tujuh = $item->c7 / $max_c7;
    //         $Rij_delapan = $item->c8 / $max_c8;

    //         $normalisasi[] = [
    //             'nama_pegawai' => $item['nama_pegawai'],
    //             'Rij_satu' => number_format($Rij_satu, 3),
    //             'Rij_dua' => number_format($Rij_dua, 3),
    //             'Rij_tiga' => number_format($Rij_tiga, 3),
    //             'Rij_empat' => number_format($Rij_empat, 3),
    //             'Rij_lima' => number_format($Rij_lima, 3),
    //             'Rij_enam' => number_format($Rij_enam, 3),
    //             'Rij_tujuh' => number_format($Rij_tujuh, 3),
    //             'Rij_delapan' => number_format($Rij_delapan, 3)
    //         ];
    //     }

    //     $hasil_akhir = [];
    //     $kriteria = Criteria::all();
    //     // Akses nilai kolom 'criteria' dari objek $kriteria
    //     // $nilai_criteria = $kriteria->pluck('criteria');

    //     // dd($normalisasi);

    //     foreach ($normalisasi as $item2) {
    //         $nilai_criteria = $kriteria->pluck('weight');
    //         // dd($nilai_criteria[1]);

    //         $nilai = (0.5 * ($item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7])) +
    //             (0.5 * (pow($item2['Rij_satu'], $nilai_criteria[0]) * pow($item2['Rij_dua'], $nilai_criteria[1]) * pow($item2['Rij_tiga'], $nilai_criteria[2]) * pow($item2['Rij_empat'], $nilai_criteria[3]) * pow($item2['Rij_lima'], $nilai_criteria[4]) * pow($item2['Rij_enam'], $nilai_criteria[5]) * pow($item2['Rij_tujuh'], $nilai_criteria[6]) * pow($item2['Rij_delapan'], $nilai_criteria[7])));

    //         $q1 = (0.5 * ($item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7]));

    //         $q2 = (0.5 * (pow($item2['Rij_satu'], $nilai_criteria[0]) * pow($item2['Rij_dua'], $nilai_criteria[1]) * pow($item2['Rij_tiga'], $nilai_criteria[2]) * pow($item2['Rij_empat'], $nilai_criteria[3]) * pow($item2['Rij_lima'], $nilai_criteria[4]) * pow($item2['Rij_enam'], $nilai_criteria[5]) * pow($item2['Rij_tujuh'], $nilai_criteria[6]) * pow($item2['Rij_delapan'], $nilai_criteria[7])));
    //         $hasil_akhir[] = [
    //             // 'id_cuti_non' => $item2['id_cuti_non'],
    //             'nama' => $item2['nama_pegawai'],
    //             'skor_akhir' => number_format($nilai, 3),
    //             'sum q1' => $item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7],

    //             'q1' => $q1,
    //             'q2' => number_format($q2, 3),
    //             'row 1' => number_format(($item2['Rij_satu'] * $nilai_criteria[0]), 3),
    //             'row 2' => number_format(($item2['Rij_dua'] * $nilai_criteria[1]), 3),
    //             'row 3' => number_format(($item2['Rij_tiga'] * $nilai_criteria[2]), 3),
    //             'row 4' => number_format(($item2['Rij_empat'] * $nilai_criteria[3]), 3),
    //             'row 5' => number_format(($item2['Rij_lima'] * $nilai_criteria[4]), 3),
    //             'row 6' => number_format(($item2['Rij_enam'] * $nilai_criteria[5]), 3),
    //             'row 7' => number_format(($item2['Rij_tujuh'] * $nilai_criteria[6]), 3),
    //             'row 8' => number_format(($item2['Rij_delapan'] * $nilai_criteria[7]), 3),

    //         ];
    //     }

    //     dd($hasil_akhir);

    //     return view('hasil_akhir_waspas', ['data' => $hasil_akhir]);
    // }


    public function hasil_akhir()
    {


        // Ambil semua kriteria
        $kriteria = Criteria::all();

        // Ambil data penilaian dari tabel detail_penilaian
        $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
            ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
            ->where('pegawai.divisi_id', Session('user')['divisi'])
            ->whereIn('pegawai.jabatan_id', [3, 4])
            ->where('detail_penilaian.periode', 2024)
            ->get();

        // Menghitung nilai maksimum untuk setiap kriteria
        $max_values = [];
        foreach ($kriteria as $k) {
            $max_values[$k->id] = DetailPenilaian::where('criteria_id', $k->id)
                ->where('periode', 2024)
                ->max('nilai');
        }

        // Memproses normalisasi untuk setiap karyawan
        $normalisasi = [];
        foreach ($penilaian as $item) {
            if (!isset($normalisasi[$item->pegawai_id])) {
                $normalisasi[$item->pegawai_id] = [
                    'nama_pegawai' => $item->nama_pegawai,
                    'Rij' => [],
                ];
            }

            $criteria_name = $kriteria->where('id', $item->criteria_id)->first()->criteria;
            $max_value = $max_values[$item->criteria_id];
            // Menghitung nilai normalisasi Rij untuk kriteria saat ini
            $Rij = ($item->nilai / $max_value);
            $normalisasi[$item->pegawai_id]['Rij'][$criteria_name] = $Rij;
        }

        // Ubah format array untuk kebutuhan view
        $normalisasi = array_values($normalisasi);

        // $hasil_akhir = [];
        // $kriteria = Criteria::all();
        // Akses nilai kolom 'criteria' dari objek $kriteria
        // $nilai_criteria = $kriteria->pluck('criteria');

        // dd($normalisasi);

        $hasil_akhir = [];
        foreach ($normalisasi as $item) {
            $Q1 = 0;
            $Q2 = 1;
            foreach ($item['Rij'] as $key => $value) {
                $criteria_id = substr($key, 4); // Mendapatkan id kriteria dari nama kolom 'Rij_X'
                // dd($key);
                $weight = Criteria::where('criteria', $key)->value('weight');
                $Q1 += $value * $weight;
                $Q2 *= pow($value, $weight);
            }

            $nilai_akhir = 0.5 * $Q1 + 0.5 * $Q2;

            $hasil_akhir[] = [
                'nama' => $item['nama_pegawai'],
                'skor_akhir' => number_format($nilai_akhir, 3),
                'q1' => number_format($Q1, 3),
                'q2' => number_format($Q2, 3),
                'sum_q1' => number_format($Q1, 3), // Jika perlu sum_q1 beda, sesuaikan perhitungan
                // Berikut ini adalah perhitungan untuk masing-masing baris berdasarkan kriteria
                // 'row_1' => number_format($item['Rij']['Rij_1'] * Criteria::where('criteria_id', 1)->value('weight'), 3),
                // 'row_2' => number_format($item['Rij']['Rij_2'] * Criteria::where('criteria_id', 2)->value('weight'), 3),
                // 'row_3' => number_format($item['Rij']['Rij_3'] * Criteria::where('criteria_id', 3)->value('weight'), 3),
                // 'row_4' => number_format($item['Rij']['Rij_4'] * Criteria::where('criteria_id', 4)->value('weight'), 3),
                // 'row_5' => number_format($item['Rij']['Rij_5'] * Criteria::where('criteria_id', 5)->value('weight'), 3),
                // 'row_6' => number_format($item['Rij']['Rij_6'] * Criteria::where('criteria_id', 6)->value('weight'), 3),
                // 'row_7' => number_format($item['Rij']['Rij_7'] * Criteria::where('criteria_id', 7)->value('weight'), 3),
                // 'row_8' => number_format($item['Rij']['Rij_8'] * Criteria::where('criteria_id', 8)->value('weight'), 3),
            ];
        }
        // dd($hasil_akhir);
        return view('hasil_akhir_waspas_new', compact('hasil_akhir'));
    }



    public function data_hasil_akhir($jabatan, $tahun, $individu)
    {

        if ($tahun) {

            if (Session('user')['role'] === "Kepala Bagian") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 3)

                    ->where('periode', $tahun)

                    ->get();
            } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
                // dd($individu);
                if ($individu == 'individu') {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 3)
                        ->where('periode', $tahun)

                        ->get();
                } else {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 4)
                        ->where('periode', $tahun)

                        ->get();
                }
            } elseif (Session('user')['role'] === "karyawan") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 4)
                    ->where('periode', $tahun)

                    ->get();
            } else {
                if ($jabatan) {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                        ->where('pegawai.jabatan_id', $jabatan)
                        ->where('periode', $tahun)
                        ->get();
                }
            }

            $kriteria = Criteria::all();

            // Menghitung nilai maksimum untuk setiap kriteria
            $max_values = [];
            foreach ($kriteria as $k) {
                $max_values[$k->id] = DetailPenilaian::where('criteria_id', $k->id)
                    ->where('periode', 2024)
                    ->max('nilai');
            }

            // Memproses normalisasi untuk setiap karyawan
            $normalisasi = [];
            foreach ($penilaian as $item) {
                if (!isset($normalisasi[$item->pegawai_id])) {
                    $normalisasi[$item->pegawai_id] = [
                        'nama_pegawai' => $item->nama_pegawai,
                        'Rij' => [],
                    ];
                }

                $criteria_name = $kriteria->where('id', $item->criteria_id)->first()->criteria;
                $max_value = $max_values[$item->criteria_id];
                // Menghitung nilai normalisasi Rij untuk kriteria saat ini
                $Rij = ($item->nilai / $max_value);
                $normalisasi[$item->pegawai_id]['Rij'][$criteria_name] = $Rij;
            }

            // Ubah format array untuk kebutuhan view
            $normalisasi = array_values($normalisasi);

            // $hasil_akhir = [];
            // $kriteria = Criteria::all();
            // Akses nilai kolom 'criteria' dari objek $kriteria
            // $nilai_criteria = $kriteria->pluck('criteria');

            // dd($normalisasi);

            $hasil_akhir = [];
            foreach ($normalisasi as $item) {
                $Q1 = 0;
                $Q2 = 1;
                foreach ($item['Rij'] as $key => $value) {
                    $criteria_id = substr($key, 4); // Mendapatkan id kriteria dari nama kolom 'Rij_X'
                    // dd($key);
                    $weight = Criteria::where('criteria', $key)->value('weight');
                    $Q1 += $value * $weight;
                    $Q2 *= pow($value, $weight);
                }

                $nilai_akhir = 0.5 * $Q1 + 0.5 * $Q2;

                $hasil_akhir[] = [
                    'nama' => $item['nama_pegawai'],
                    'skor_akhir' => number_format($nilai_akhir, 3),
                    'q1' => number_format($Q1, 3),
                    'q2' => number_format($Q2, 3),
                    'sum_q1' => number_format($Q1, 3), // Jika perlu sum_q1 beda, sesuaikan perhitungan
                    // Berikut ini adalah perhitungan untuk masing-masing baris berdasarkan kriteria
                    // 'row_1' => number_format($item['Rij']['Rij_1'] * Criteria::where('criteria_id', 1)->value('weight'), 3),
                    // 'row_2' => number_format($item['Rij']['Rij_2'] * Criteria::where('criteria_id', 2)->value('weight'), 3),
                    // 'row_3' => number_format($item['Rij']['Rij_3'] * Criteria::where('criteria_id', 3)->value('weight'), 3),
                    // 'row_4' => number_format($item['Rij']['Rij_4'] * Criteria::where('criteria_id', 4)->value('weight'), 3),
                    // 'row_5' => number_format($item['Rij']['Rij_5'] * Criteria::where('criteria_id', 5)->value('weight'), 3),
                    // 'row_6' => number_format($item['Rij']['Rij_6'] * Criteria::where('criteria_id', 6)->value('weight'), 3),
                    // 'row_7' => number_format($item['Rij']['Rij_7'] * Criteria::where('criteria_id', 7)->value('weight'), 3),
                    // 'row_8' => number_format($item['Rij']['Rij_8'] * Criteria::where('criteria_id', 8)->value('weight'), 3),
                ];
            }

            usort($hasil_akhir, function ($a, $b) {
                return $b['skor_akhir'] <=> $a['skor_akhir'];
            });
            return $hasil_akhir;
        } else {
            $hasil_akhir = [];
            return $hasil_akhir;
        }
    }

    public function export_data_hasil_akhir($jabatan, $tahun, $individu)
    {

        if ($tahun) {

            if (Session('user')['role'] === "Kepala Bagian") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 3)

                    ->where('periode', $tahun)

                    ->get();
            } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
                // dd($individu);
                if ($individu == 'individu') {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 3)
                        ->where('periode', $tahun)

                        ->get();
                } else {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 4)
                        ->where('periode', $tahun)

                        ->get();
                }
            } elseif (Session('user')['role'] === "karyawan") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 4)
                    ->where('periode', $tahun)

                    ->get();
            } else {
                if ($jabatan) {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                        ->where('pegawai.jabatan_id', $jabatan)
                        ->where('periode', $tahun)
                        ->get();
                }
            }

            $kriteria = Criteria::all();

            // Menghitung nilai maksimum untuk setiap kriteria
            $max_values = [];
            foreach ($kriteria as $k) {
                $max_values[$k->id] = DetailPenilaian::where('criteria_id', $k->id)
                    ->where('periode', 2024)
                    ->max('nilai');
            }

            // Memproses normalisasi untuk setiap karyawan
            $normalisasi = [];
            foreach ($penilaian as $item) {
                if (!isset($normalisasi[$item->pegawai_id])) {
                    $normalisasi[$item->pegawai_id] = [
                        'nama_pegawai' => $item->nama_pegawai,
                        'Rij' => [],
                    ];
                }

                $criteria_name = $kriteria->where('id', $item->criteria_id)->first()->criteria;
                $max_value = $max_values[$item->criteria_id];
                // Menghitung nilai normalisasi Rij untuk kriteria saat ini
                $Rij = ($item->nilai / $max_value);
                $normalisasi[$item->pegawai_id]['Rij'][$criteria_name] = $Rij;
            }

            // Ubah format array untuk kebutuhan view
            $normalisasi = array_values($normalisasi);

            // $hasil_akhir = [];
            // $kriteria = Criteria::all();
            // Akses nilai kolom 'criteria' dari objek $kriteria
            // $nilai_criteria = $kriteria->pluck('criteria');

            // dd($normalisasi);

            $hasil_akhir = [];
            foreach ($normalisasi as $item) {
                $Q1 = 0;
                $Q2 = 1;
                foreach ($item['Rij'] as $key => $value) {
                    $criteria_id = substr($key, 4); // Mendapatkan id kriteria dari nama kolom 'Rij_X'
                    // dd($key);
                    $weight = Criteria::where('criteria', $key)->value('weight');
                    $Q1 += $value * $weight;
                    $Q2 *= pow($value, $weight);
                }

                $nilai_akhir = 0.5 * $Q1 + 0.5 * $Q2;

                $hasil_akhir[] = [
                    'nama' => $item['nama_pegawai'],
                    'skor_akhir' => number_format($nilai_akhir, 3),
                    // 'q1' => number_format($Q1, 3),
                    // 'q2' => number_format($Q2, 3),
                    // 'sum_q1' => number_format($Q1, 3), // Jika perlu sum_q1 beda, sesuaikan perhitungan
                    // Berikut ini adalah perhitungan untuk masing-masing baris berdasarkan kriteria
                    // 'row_1' => number_format($item['Rij']['Rij_1'] * Criteria::where('criteria_id', 1)->value('weight'), 3),
                    // 'row_2' => number_format($item['Rij']['Rij_2'] * Criteria::where('criteria_id', 2)->value('weight'), 3),
                    // 'row_3' => number_format($item['Rij']['Rij_3'] * Criteria::where('criteria_id', 3)->value('weight'), 3),
                    // 'row_4' => number_format($item['Rij']['Rij_4'] * Criteria::where('criteria_id', 4)->value('weight'), 3),
                    // 'row_5' => number_format($item['Rij']['Rij_5'] * Criteria::where('criteria_id', 5)->value('weight'), 3),
                    // 'row_6' => number_format($item['Rij']['Rij_6'] * Criteria::where('criteria_id', 6)->value('weight'), 3),
                    // 'row_7' => number_format($item['Rij']['Rij_7'] * Criteria::where('criteria_id', 7)->value('weight'), 3),
                    // 'row_8' => number_format($item['Rij']['Rij_8'] * Criteria::where('criteria_id', 8)->value('weight'), 3),
                ];
            }

            usort($hasil_akhir, function ($a, $b) {
                return $b['skor_akhir'] <=> $a['skor_akhir'];
            });
            return $hasil_akhir;
        } else {
            $hasil_akhir = [];
            return $hasil_akhir;
        }
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}
