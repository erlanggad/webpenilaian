<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\DetailPenilaian;
use App\Models\Pengajuan_cuti;
use App\Models\Pengajuan_cuti_non;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PerhitunganTopsisController extends Controller
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

    //     $jumlah_kuadrat_c1 = 0;
    //     $jumlah_kuadrat_c2 = 0;
    //     $jumlah_kuadrat_c3 = 0;
    //     $jumlah_kuadrat_c4 = 0;
    //     $jumlah_kuadrat_c5 = 0;
    //     $jumlah_kuadrat_c6 = 0;
    //     $jumlah_kuadrat_c7 = 0;
    //     $jumlah_kuadrat_c8 = 0;


    //     foreach ($penilaian as $item) {
    //         // Hitung jumlah kuadrat dari nilai-nilai
    //         $jumlah_kuadrat_c1 += pow($item->c1, 2);
    //         $jumlah_kuadrat_c2 += pow($item->c2, 2);
    //         $jumlah_kuadrat_c3 += pow($item->c3, 2);
    //         $jumlah_kuadrat_c4 += pow($item->c4, 2);
    //         $jumlah_kuadrat_c5 += pow($item->c5, 2);
    //         $jumlah_kuadrat_c6 += pow($item->c6, 2);
    //         $jumlah_kuadrat_c7 += pow($item->c7, 2);
    //         $jumlah_kuadrat_c8 += pow($item->c8, 2);
    //     }

    //     // Hitung akar kuadrat dari jumlah kuadrat
    //     $hasil_c1 = sqrt($jumlah_kuadrat_c1);
    //     $hasil_c2 = sqrt($jumlah_kuadrat_c2);
    //     $hasil_c3 = sqrt($jumlah_kuadrat_c3);
    //     $hasil_c4 = sqrt($jumlah_kuadrat_c4);
    //     $hasil_c5 = sqrt($jumlah_kuadrat_c5);
    //     $hasil_c6 = sqrt($jumlah_kuadrat_c6);
    //     $hasil_c7 = sqrt($jumlah_kuadrat_c7);
    //     $hasil_c8 = sqrt($jumlah_kuadrat_c8);



    //     $normalisasi = [];

    //     foreach ($penilaian as $item) {
    //         $normalisasi[] = [
    //             'nama_pegawai' => $item['nama_pegawai'],
    //             "c1" => number_format($item->c1 / $hasil_c1, 3),
    //             "c2" => number_format($item->c2 / $hasil_c2, 3),
    //             "c3" => number_format($item->c3 / $hasil_c3, 3),
    //             "c4" => number_format($item->c4 / $hasil_c4, 3),
    //             "c5" => number_format($item->c5 / $hasil_c5, 3),
    //             "c6" => number_format($item->c6 / $hasil_c6, 3),
    //             "c7" => number_format($item->c7 / $hasil_c7, 3),
    //             "c8" => number_format($item->c8 / $hasil_c8, 3),
    //         ];
    //     }


    //     return view('normalisasi_penilaian_topsis', ['data' => $normalisasi]);
    // }

    public function normalisasi()
    {

        $role = session('user')['role'];
        $divisiId = session('user')['divisi'];
        $periode = 2024; // Sesuaikan dengan periode yang diinginkan

        if ($role === "Kepala Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 3)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        } elseif ($role === "Kepala Sub Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 4)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        }

        $kriteria = Criteria::all();
        // dd($penilaian);
        // Inisialisasi array untuk menyimpan jumlah kuadrat dari setiap kriteria
        // Mengelompokkan nilai berdasarkan kriteria
        $grouped_values = [];
        foreach ($penilaian as $item) {
            $criterion = $item->criteria;
            if (!isset($grouped_values[$criterion])) {
                $grouped_values[$criterion] = [];
            }
            $grouped_values[$criterion][] = $item->nilai;
        }

        // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
        $hasil_kuadrat = [];
        foreach ($grouped_values as $criterion => $values) {
            $sum_of_squares = 0;
            foreach ($values as $value) {
                $sum_of_squares += pow($value, 2);
            }
            $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
        }

        // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
        $normalisasi = [];
        foreach ($penilaian as $item) {
            $nama_pegawai = $item->nama_pegawai;
            if (!isset($normalisasi[$nama_pegawai])) {
                $normalisasi[$nama_pegawai] = [
                    'nama_pegawai' => $nama_pegawai,
                ];
            }

            $criterion = $item->criteria;
            $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
            $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
        }

        // Konversi normalisasi ke array indexed (bukan associative) untuk tampilan yang lebih mudah
        $normalisasi = array_values($normalisasi);

        // Cetak hasil
        // dd($normalisasi);

        return view('normalisasi_penilaian_topsis', compact('normalisasi', 'kriteria'));
    }

    // public function hasil_normalisasi_terbobot()
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

    //     $jumlah_kuadrat_c1 = 0;
    //     $jumlah_kuadrat_c2 = 0;
    //     $jumlah_kuadrat_c3 = 0;
    //     $jumlah_kuadrat_c4 = 0;
    //     $jumlah_kuadrat_c5 = 0;
    //     $jumlah_kuadrat_c6 = 0;
    //     $jumlah_kuadrat_c7 = 0;
    //     $jumlah_kuadrat_c8 = 0;


    //     foreach ($penilaian as $item) {
    //         // Hitung jumlah kuadrat dari nilai-nilai
    //         $jumlah_kuadrat_c1 += pow($item->c1, 2);
    //         $jumlah_kuadrat_c2 += pow($item->c2, 2);
    //         $jumlah_kuadrat_c3 += pow($item->c3, 2);
    //         $jumlah_kuadrat_c4 += pow($item->c4, 2);
    //         $jumlah_kuadrat_c5 += pow($item->c5, 2);
    //         $jumlah_kuadrat_c6 += pow($item->c6, 2);
    //         $jumlah_kuadrat_c7 += pow($item->c7, 2);
    //         $jumlah_kuadrat_c8 += pow($item->c8, 2);
    //     }

    //     // Hitung akar kuadrat dari jumlah kuadrat
    //     $hasil_c1 = sqrt($jumlah_kuadrat_c1);
    //     $hasil_c2 = sqrt($jumlah_kuadrat_c2);
    //     $hasil_c3 = sqrt($jumlah_kuadrat_c3);
    //     $hasil_c4 = sqrt($jumlah_kuadrat_c4);
    //     $hasil_c5 = sqrt($jumlah_kuadrat_c5);
    //     $hasil_c6 = sqrt($jumlah_kuadrat_c6);
    //     $hasil_c7 = sqrt($jumlah_kuadrat_c7);
    //     $hasil_c8 = sqrt($jumlah_kuadrat_c8);



    //     $normalisasi = [];

    //     foreach ($penilaian as $item) {
    //         $normalisasi[] = [
    //             'nama_pegawai' => $item['nama_pegawai'],
    //             "c1" => number_format($item->c1 / number_format($hasil_c1, 1), 3),
    //             "c2" => number_format($item->c2 / number_format($hasil_c2, 1), 3),
    //             "c3" => number_format($item->c3 / number_format($hasil_c3, 1), 3),
    //             "c4" => number_format($item->c4 / number_format($hasil_c4, 1), 3),
    //             "c5" => number_format($item->c5 / number_format($hasil_c5, 1), 3),
    //             "c6" => number_format($item->c6 / number_format($hasil_c6, 1), 3),
    //             "c7" => number_format($item->c7 / number_format($hasil_c7, 1), 3),
    //             "c8" => number_format($item->c8 / number_format($hasil_c8, 1), 3),
    //         ];
    //     }

    //     $kriteria = Criteria::all();
    //     $atribut_optimal = [];

    //     foreach ($normalisasi as $item_normalisasi) {
    //         $nilai_criteria = $kriteria->pluck('weight');
    //         // dd($item_normalisasi['c1']);
    //         $atribut_optimal[] = [
    //             'nama_pegawai' => $item_normalisasi['nama_pegawai'],
    //             // "c1 normalisasi" => $item_normalisasi['c1'],
    //             "c1" => number_format($item_normalisasi['c1'] * $nilai_criteria[0], 3),
    //             "c2" => number_format($item_normalisasi['c2'] * $nilai_criteria[1], 3),
    //             "c3" => number_format($item_normalisasi['c3'] * $nilai_criteria[2], 3),
    //             "c4" => number_format($item_normalisasi['c4'] * $nilai_criteria[3], 3),
    //             "c5" => number_format($item_normalisasi['c5'] * $nilai_criteria[4], 3),
    //             "c6" => number_format($item_normalisasi['c6'] * $nilai_criteria[5], 3),
    //             "c7" => number_format($item_normalisasi['c7'] * $nilai_criteria[6], 3),
    //             "c8" => number_format($item_normalisasi['c8'] * $nilai_criteria[7], 3),
    //         ];
    //     }
    //     //   dd($atribut_optimal);

    //     return view('normalisasi_terbobot_topsis', ['data' => $atribut_optimal]);
    // }

    public function hasil_normalisasi_terbobot()
    {

        $role = session('user')['role'];
        $divisiId = session('user')['divisi'];
        $periode = 2024; // Sesuaikan dengan periode yang diinginkan

        if ($role === "Kepala Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 3)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        } elseif ($role === "Kepala Sub Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 4)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        }

        $kriteria = Criteria::all();
        // dd($penilaian);
        // Inisialisasi array untuk menyimpan jumlah kuadrat dari setiap kriteria
        // Mengelompokkan nilai berdasarkan kriteria
        $grouped_values = [];
        foreach ($penilaian as $item) {
            $criterion = $item->criteria;
            if (!isset($grouped_values[$criterion])) {
                $grouped_values[$criterion] = [];
            }
            $grouped_values[$criterion][] = $item->nilai;
        }

        // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
        $hasil_kuadrat = [];
        foreach ($grouped_values as $criterion => $values) {
            $sum_of_squares = 0;
            foreach ($values as $value) {
                $sum_of_squares += pow($value, 2);
            }
            $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
        }

        // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
        $normalisasi = [];
        foreach ($penilaian as $item) {
            $nama_pegawai = $item->nama_pegawai;
            if (!isset($normalisasi[$nama_pegawai])) {
                $normalisasi[$nama_pegawai] = [
                    'nama_pegawai' => $nama_pegawai,
                ];
            }

            $criterion = $item->criteria;
            $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
            $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
        }

        // Konversi normalisasi ke array indexed (bukan associative) untuk tampilan yang lebih mudah
        $normalisasi = array_values($normalisasi);

        // $kriteria = Criteria::all();
        $atribut_optimal = [];

        $nilai_criteria = $kriteria->pluck('weight')->toArray();
        $nama_kriteria = $kriteria->pluck('criteria')->toArray();

        foreach ($normalisasi as $item_normalisasi) {
            $atribut_optimal_item = ['nama_pegawai' => $item_normalisasi['nama_pegawai']];

            // Iterasi sesuai dengan jumlah kriteria
            for ($i = 0; $i < count($nama_kriteria); $i++) {
                $kriteria_key = 'C' . ($i + 1); // Nama kriteria (C1, C2, dst)
                $nilai_normalisasi = $item_normalisasi[$kriteria_key]; // Nilai normalisasi untuk kriteria saat ini
                $bobot = $nilai_criteria[$i]; // Bobot dari model Criteria untuk kriteria saat ini

                // Hitung atribut optimal dan simpan dalam array
                $atribut_optimal_item[$kriteria_key] = number_format($nilai_normalisasi * $bobot, 3);
            }

            // Tambahkan hasil perhitungan untuk satu pegawai ke dalam hasil akhir
            $atribut_optimal[] = $atribut_optimal_item;
        }

        // Debugging hasil atribut optimal
        // dd($atribut_optimal);

        return view('normalisasi_terbobot_topsis', compact('atribut_optimal', 'kriteria'));
    }

    // public function hasil_solusi_ideal()
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

    //     if ($penilaian->count() > 0) {
    //         $jumlah_kuadrat_c1 = 0;
    //         $jumlah_kuadrat_c2 = 0;
    //         $jumlah_kuadrat_c3 = 0;
    //         $jumlah_kuadrat_c4 = 0;
    //         $jumlah_kuadrat_c5 = 0;
    //         $jumlah_kuadrat_c6 = 0;
    //         $jumlah_kuadrat_c7 = 0;
    //         $jumlah_kuadrat_c8 = 0;


    //         foreach ($penilaian as $item) {
    //             // Hitung jumlah kuadrat dari nilai-nilai
    //             $jumlah_kuadrat_c1 += pow($item->c1, 2);
    //             $jumlah_kuadrat_c2 += pow($item->c2, 2);
    //             $jumlah_kuadrat_c3 += pow($item->c3, 2);
    //             $jumlah_kuadrat_c4 += pow($item->c4, 2);
    //             $jumlah_kuadrat_c5 += pow($item->c5, 2);
    //             $jumlah_kuadrat_c6 += pow($item->c6, 2);
    //             $jumlah_kuadrat_c7 += pow($item->c7, 2);
    //             $jumlah_kuadrat_c8 += pow($item->c8, 2);
    //         }

    //         // Hitung akar kuadrat dari jumlah kuadrat
    //         $hasil_c1 = sqrt($jumlah_kuadrat_c1);
    //         $hasil_c2 = sqrt($jumlah_kuadrat_c2);
    //         $hasil_c3 = sqrt($jumlah_kuadrat_c3);
    //         $hasil_c4 = sqrt($jumlah_kuadrat_c4);
    //         $hasil_c5 = sqrt($jumlah_kuadrat_c5);
    //         $hasil_c6 = sqrt($jumlah_kuadrat_c6);
    //         $hasil_c7 = sqrt($jumlah_kuadrat_c7);
    //         $hasil_c8 = sqrt($jumlah_kuadrat_c8);



    //         $normalisasi = [];

    //         foreach ($penilaian as $item) {
    //             $normalisasi[] = [
    //                 'nama_pegawai' => $item['nama_pegawai'],
    //                 "c1" => number_format($item->c1 / number_format($hasil_c1, 1), 3),
    //                 "c2" => number_format($item->c2 / number_format($hasil_c2, 1), 3),
    //                 "c3" => number_format($item->c3 / number_format($hasil_c3, 1), 3),
    //                 "c4" => number_format($item->c4 / number_format($hasil_c4, 1), 3),
    //                 "c5" => number_format($item->c5 / number_format($hasil_c5, 1), 3),
    //                 "c6" => number_format($item->c6 / number_format($hasil_c6, 1), 3),
    //                 "c7" => number_format($item->c7 / number_format($hasil_c7, 1), 3),
    //                 "c8" => number_format($item->c8 / number_format($hasil_c8, 1), 3),
    //             ];
    //         }

    //         $kriteria = Criteria::all();
    //         $atribut_optimal = [];

    //         foreach ($normalisasi as $item_normalisasi) {
    //             $nilai_criteria = $kriteria->pluck('weight');
    //             // dd($item_normalisasi['c1']);
    //             $atribut_optimal[] = [
    //                 'nama_pegawai' => $item_normalisasi['nama_pegawai'],
    //                 // "c1 normalisasi" => $item_normalisasi['c1'],
    //                 "c1" => number_format($item_normalisasi['c1'] * $nilai_criteria[0], 3),
    //                 "c2" => number_format($item_normalisasi['c2'] * $nilai_criteria[1], 3),
    //                 "c3" => number_format($item_normalisasi['c3'] * $nilai_criteria[2], 3),
    //                 "c4" => number_format($item_normalisasi['c4'] * $nilai_criteria[3], 3),
    //                 "c5" => number_format($item_normalisasi['c5'] * $nilai_criteria[4], 3),
    //                 "c6" => number_format($item_normalisasi['c6'] * $nilai_criteria[5], 3),
    //                 "c7" => number_format($item_normalisasi['c7'] * $nilai_criteria[6], 3),
    //                 "c8" => number_format($item_normalisasi['c8'] * $nilai_criteria[7], 3),
    //             ];
    //         }


    //         $solusi_ideal = [];

    //         $max_c1 = -INF; // Inisialisasi nilai maksimum untuk c1
    //         $max_c2 = -INF; // Inisialisasi nilai maksimum untuk c2
    //         $max_c3 = -INF; // Inisialisasi nilai maksimum untuk c3
    //         $max_c4 = -INF; // Inisialisasi nilai maksimum untuk c4
    //         $max_c5 = -INF; // Inisialisasi nilai maksimum untuk c5
    //         $max_c6 = -INF; // Inisialisasi nilai maksimum untuk c6
    //         $max_c7 = -INF; // Inisialisasi nilai maksimum untuk c7
    //         $max_c8 = -INF; // Inisialisasi nilai maksimum untuk c8


    //         foreach ($atribut_optimal as $item) {
    //             // dd($item);
    //             // Update nilai maksimum untuk setiap kriteria
    //             $max_c1 = max($max_c1, $item['c1']);
    //             $max_c2 = max($max_c2, $item['c2']);
    //             $max_c3 = max($max_c3, $item['c3']);
    //             $max_c4 = max($max_c4, $item['c4']);
    //             $max_c5 = max($max_c5, $item['c5']);
    //             $max_c6 = max($max_c6, $item['c6']);
    //             $max_c7 = max($max_c7, $item['c7']);
    //             $max_c8 = max($max_c8, $item['c8']);




    //             // dd($item->c1);
    //         }

    //         $min_c1 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c1
    //         $min_c2 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c2
    //         $min_c3 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c3
    //         $min_c4 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c4
    //         $min_c5 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c5
    //         $min_c6 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c6
    //         $min_c7 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c7
    //         $min_c8 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c8



    //         foreach ($atribut_optimal as $item) {
    //             // dd($item);
    //             // Update nilai maksimum untuk setiap kriteria
    //             $min_c1 = min($min_c1, $item['c1']);
    //             $min_c2 = min($min_c2, $item['c2']);
    //             $min_c3 = min($min_c3, $item['c3']);
    //             $min_c4 = min($min_c4, $item['c4']);
    //             $min_c5 = min($min_c5, $item['c5']);
    //             $min_c6 = min($min_c6, $item['c6']);
    //             $min_c7 = min($min_c7, $item['c7']);
    //             $min_c8 = min($min_c8, $item['c8']);
    //         }

    //         $solusi_ideal = [
    //             "solusi_ideal_positif" => [
    //                 "max_c1 " => $max_c1,
    //                 "max_c2 " => $max_c2,
    //                 "max_c3 " => $max_c3,
    //                 "max_c4 " => $max_c4,
    //                 "max_c5 " => $max_c5,
    //                 "max_c6 " => $max_c6,
    //                 "max_c7 " => $max_c7,
    //                 "max_c8 " => $max_c8,
    //             ],
    //             "solusi_ideal_negatif" => [
    //                 "min_c1 " => $min_c1,
    //                 "min_c2 " => $min_c2,
    //                 "min_c3 " => $min_c3,
    //                 "min_c4 " => $min_c4,
    //                 "min_c5 " => $min_c5,
    //                 "min_c6 " => $min_c6,
    //                 "min_c7 " => $min_c7,
    //                 "min_c8 " => $min_c8,
    //             ]
    //         ];

    //         $tipe_solusi_ideal = [
    //             "solusi ideal negatif",
    //             "solusi ideal positif"
    //         ];
    //         //   dd($solusi_ideal['solusi_ideal_negatif']);

    //         return view('solusi_ideal_topsis', ['data' => $solusi_ideal, 'tipe' => $tipe_solusi_ideal]);
    //     } else {
    //         $solusi_ideal = [
    //             "solusi_ideal_positif" => [],
    //             "solusi_ideal_negatif" => []
    //         ];
    //         $tipe_solusi_ideal = [
    //             "solusi ideal negatif",
    //             "solusi ideal positif"
    //         ];
    //         return view('solusi_ideal_topsis', ['data' => $solusi_ideal, 'tipe' => $tipe_solusi_ideal]);
    //     }
    // }

    public function hasil_solusi_ideal()
    {

        $role = session('user')['role'];
        $divisiId = session('user')['divisi'];
        $periode = 2024; // Sesuaikan dengan periode yang diinginkan

        if ($role === "Kepala Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 3)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        } elseif ($role === "Kepala Sub Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 4)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        }

        $kriteria = Criteria::all();


        if ($penilaian->count() > 0) {
            $grouped_values = [];
            foreach ($penilaian as $item) {
                $criterion = $item->criteria;
                if (!isset($grouped_values[$criterion])) {
                    $grouped_values[$criterion] = [];
                }
                $grouped_values[$criterion][] = $item->nilai;
            }

            // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
            $hasil_kuadrat = [];
            foreach ($grouped_values as $criterion => $values) {
                $sum_of_squares = 0;
                foreach ($values as $value) {
                    $sum_of_squares += pow($value, 2);
                }
                $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
            }

            // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
            $normalisasi = [];
            foreach ($penilaian as $item) {
                $nama_pegawai = $item->nama_pegawai;
                if (!isset($normalisasi[$nama_pegawai])) {
                    $normalisasi[$nama_pegawai] = [
                        'nama_pegawai' => $nama_pegawai,
                    ];
                }

                $criterion = $item->criteria;
                $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
                $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
            }

            // Konversi normalisasi ke array indexed (bukan associative) untuk tampilan yang lebih mudah
            $normalisasi = array_values($normalisasi);

            // $kriteria = Criteria::all();
            $atribut_optimal = [];

            $nilai_criteria = $kriteria->pluck('weight')->toArray();
            $nama_kriteria = $kriteria->pluck('criteria')->toArray();

            foreach ($normalisasi as $item_normalisasi) {
                $atribut_optimal_item = ['nama_pegawai' => $item_normalisasi['nama_pegawai']];

                // Iterasi sesuai dengan jumlah kriteria
                for ($i = 0; $i < count($nama_kriteria); $i++) {
                    $kriteria_key = 'C' . ($i + 1); // Nama kriteria (C1, C2, dst)
                    $nilai_normalisasi = $item_normalisasi[$kriteria_key]; // Nilai normalisasi untuk kriteria saat ini
                    $bobot = $nilai_criteria[$i]; // Bobot dari model Criteria untuk kriteria saat ini

                    // Hitung atribut optimal dan simpan dalam array
                    $atribut_optimal_item[$kriteria_key] = number_format($nilai_normalisasi * $bobot, 3);
                }

                // Tambahkan hasil perhitungan untuk satu pegawai ke dalam hasil akhir
                $atribut_optimal[] = $atribut_optimal_item;
            }

            // Debugging hasil atribut optimal
            // dd($atribut_optimal);

            // Inisialisasi solusi ideal
            $solusi_ideal = [
                "solusi_ideal_positif" => [],
                "solusi_ideal_negatif" => [],
            ];

            // Inisialisasi nilai maksimum dan minimum untuk setiap kriteria
            foreach ($kriteria as $k) {
                $solusi_ideal["solusi_ideal_positif"][$k->criteria] = -INF;
                $solusi_ideal["solusi_ideal_negatif"][$k->criteria] = INF;
            }

            // Menghitung nilai maksimum dan minimum untuk setiap kriteria
            foreach ($atribut_optimal as $item) {
                foreach ($kriteria as $k) {
                    $criterion = $k->criteria;
                    $solusi_ideal["solusi_ideal_positif"][$criterion] = max($solusi_ideal["solusi_ideal_positif"][$criterion], $item[$criterion]);
                    $solusi_ideal["solusi_ideal_negatif"][$criterion] = min($solusi_ideal["solusi_ideal_negatif"][$criterion], $item[$criterion]);
                }
            }

            // Hasil solusi ideal
            $tipe_solusi_ideal = [
                "solusi ideal negatif",
                "solusi ideal positif"
            ];

            // dd($solusi_ideal);

            return view('solusi_ideal_topsis', compact('solusi_ideal', 'tipe_solusi_ideal', 'kriteria'));
        } else {
            $solusi_ideal = [
                "solusi_ideal_positif" => [],
                "solusi_ideal_negatif" => []
            ];
            $tipe_solusi_ideal = [
                "solusi ideal negatif",
                "solusi ideal positif"
            ];
            return view('solusi_ideal_topsis', compact('solusi_ideal', 'tipe_solusi_ideal', 'kriteria'));
        }
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

    //     $jumlah_kuadrat_c1 = 0;
    //     $jumlah_kuadrat_c2 = 0;
    //     $jumlah_kuadrat_c3 = 0;
    //     $jumlah_kuadrat_c4 = 0;
    //     $jumlah_kuadrat_c5 = 0;
    //     $jumlah_kuadrat_c6 = 0;
    //     $jumlah_kuadrat_c7 = 0;
    //     $jumlah_kuadrat_c8 = 0;


    //     foreach ($penilaian as $item) {
    //         // Hitung jumlah kuadrat dari nilai-nilai
    //         $jumlah_kuadrat_c1 += pow($item->c1, 2);
    //         $jumlah_kuadrat_c2 += pow($item->c2, 2);
    //         $jumlah_kuadrat_c3 += pow($item->c3, 2);
    //         $jumlah_kuadrat_c4 += pow($item->c4, 2);
    //         $jumlah_kuadrat_c5 += pow($item->c5, 2);
    //         $jumlah_kuadrat_c6 += pow($item->c6, 2);
    //         $jumlah_kuadrat_c7 += pow($item->c7, 2);
    //         $jumlah_kuadrat_c8 += pow($item->c8, 2);
    //     }

    //     // Hitung akar kuadrat dari jumlah kuadrat
    //     $hasil_c1 = sqrt($jumlah_kuadrat_c1);
    //     $hasil_c2 = sqrt($jumlah_kuadrat_c2);
    //     $hasil_c3 = sqrt($jumlah_kuadrat_c3);
    //     $hasil_c4 = sqrt($jumlah_kuadrat_c4);
    //     $hasil_c5 = sqrt($jumlah_kuadrat_c5);
    //     $hasil_c6 = sqrt($jumlah_kuadrat_c6);
    //     $hasil_c7 = sqrt($jumlah_kuadrat_c7);
    //     $hasil_c8 = sqrt($jumlah_kuadrat_c8);



    //     $normalisasi = [];

    //     foreach ($penilaian as $item) {
    //         $normalisasi[] = [
    //             'nama_pegawai' => $item['nama_pegawai'],
    //             "c1" => number_format($item->c1 / number_format($hasil_c1, 1), 3),
    //             "c2" => number_format($item->c2 / number_format($hasil_c2, 1), 3),
    //             "c3" => number_format($item->c3 / number_format($hasil_c3, 1), 3),
    //             "c4" => number_format($item->c4 / number_format($hasil_c4, 1), 3),
    //             "c5" => number_format($item->c5 / number_format($hasil_c5, 1), 3),
    //             "c6" => number_format($item->c6 / number_format($hasil_c6, 1), 3),
    //             "c7" => number_format($item->c7 / number_format($hasil_c7, 1), 3),
    //             "c8" => number_format($item->c8 / number_format($hasil_c8, 1), 3),
    //         ];
    //     }

    //     $kriteria = Criteria::all();
    //     $atribut_optimal = [];

    //     foreach ($normalisasi as $item_normalisasi) {
    //         $nilai_criteria = $kriteria->pluck('weight');
    //         // dd($item_normalisasi['c1']);
    //         $atribut_optimal[] = [
    //             'nama_pegawai' => $item_normalisasi['nama_pegawai'],
    //             // "c1 normalisasi" => $item_normalisasi['c1'],
    //             "c1" => number_format($item_normalisasi['c1'] * $nilai_criteria[0], 3),
    //             "c2" => number_format($item_normalisasi['c2'] * $nilai_criteria[1], 3),
    //             "c3" => number_format($item_normalisasi['c3'] * $nilai_criteria[2], 3),
    //             "c4" => number_format($item_normalisasi['c4'] * $nilai_criteria[3], 3),
    //             "c5" => number_format($item_normalisasi['c5'] * $nilai_criteria[4], 3),
    //             "c6" => number_format($item_normalisasi['c6'] * $nilai_criteria[5], 3),
    //             "c7" => number_format($item_normalisasi['c7'] * $nilai_criteria[6], 3),
    //             "c8" => number_format($item_normalisasi['c8'] * $nilai_criteria[7], 3),
    //         ];
    //     }


    //     $solusi_ideal = [];

    //     $max_c1 = -INF; // Inisialisasi nilai maksimum untuk c1
    //     $max_c2 = -INF; // Inisialisasi nilai maksimum untuk c2
    //     $max_c3 = -INF; // Inisialisasi nilai maksimum untuk c3
    //     $max_c4 = -INF; // Inisialisasi nilai maksimum untuk c4
    //     $max_c5 = -INF; // Inisialisasi nilai maksimum untuk c5
    //     $max_c6 = -INF; // Inisialisasi nilai maksimum untuk c6
    //     $max_c7 = -INF; // Inisialisasi nilai maksimum untuk c7
    //     $max_c8 = -INF; // Inisialisasi nilai maksimum untuk c8


    //     foreach ($atribut_optimal as $item) {
    //         // dd($item);
    //         // Update nilai maksimum untuk setiap kriteria
    //         $max_c1 = max($max_c1, $item['c1']);
    //         $max_c2 = max($max_c2, $item['c2']);
    //         $max_c3 = max($max_c3, $item['c3']);
    //         $max_c4 = max($max_c4, $item['c4']);
    //         $max_c5 = max($max_c5, $item['c5']);
    //         $max_c6 = max($max_c6, $item['c6']);
    //         $max_c7 = max($max_c7, $item['c7']);
    //         $max_c8 = max($max_c8, $item['c8']);




    //         // dd($item->c1);
    //     }

    //     $min_c1 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c1
    //     $min_c2 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c2
    //     $min_c3 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c3
    //     $min_c4 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c4
    //     $min_c5 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c5
    //     $min_c6 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c6
    //     $min_c7 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c7
    //     $min_c8 = PHP_INT_MAX; // Inisialisasi nilai minimum untuk c8



    //     foreach ($atribut_optimal as $item) {
    //         // dd($item);
    //         // Update nilai maksimum untuk setiap kriteria
    //         $min_c1 = min($min_c1, $item['c1']);
    //         $min_c2 = min($min_c2, $item['c2']);
    //         $min_c3 = min($min_c3, $item['c3']);
    //         $min_c4 = min($min_c4, $item['c4']);
    //         $min_c5 = min($min_c5, $item['c5']);
    //         $min_c6 = min($min_c6, $item['c6']);
    //         $min_c7 = min($min_c7, $item['c7']);
    //         $min_c8 = min($min_c8, $item['c8']);
    //     }

    //     $solusi_ideal = [
    //         "solusi_ideal_positif" => [
    //             "max_c1 " => $max_c1,
    //             "max_c2 " => $max_c2,
    //             "max_c3 " => $max_c3,
    //             "max_c4 " => $max_c4,
    //             "max_c5 " => $max_c5,
    //             "max_c6 " => $max_c6,
    //             "max_c7 " => $max_c7,
    //             "max_c8 " => $max_c8,
    //         ],
    //         "solusi_ideal_negatif" => [
    //             "min_c1 " => $min_c1,
    //             "min_c2 " => $min_c2,
    //             "min_c3 " => $min_c3,
    //             "min_c4 " => $min_c4,
    //             "min_c5 " => $min_c5,
    //             "min_c6 " => $min_c6,
    //             "min_c7 " => $min_c7,
    //             "min_c8 " => $min_c8,
    //         ]
    //     ];

    //     $tipe_solusi_ideal = [
    //         "solusi ideal negatif",
    //         "solusi ideal positif"
    //     ];

    //     $hasil_akhir = [];

    //     // dd($max_c1);

    //     foreach ($atribut_optimal as $item) {
    //         $hasil_positif = number_format(sqrt(
    //             pow(($max_c1 -  $item['c1']), 2) +
    //                 pow(($max_c2 - $item['c2']), 2) +
    //                 pow(($max_c3 -  $item['c3']), 2) +
    //                 pow(($max_c4 - $item['c4']), 2) +
    //                 pow(($max_c5 - $item['c5']), 2) +
    //                 pow(($max_c6 - $item['c6']), 2) +
    //                 pow(($max_c7 - $item['c7']), 2) +
    //                 pow(($max_c8 - $item['c8']), 2)
    //         ), 3);

    //         $hasil_negatif = number_format(
    //             sqrt(
    //                 pow(($item['c1'] - $min_c1), 2) +
    //                     pow(($item['c2'] - $min_c2), 2) +
    //                     pow(($item['c3'] - $min_c3), 2) +
    //                     pow(($item['c4'] - $min_c4), 2) +
    //                     pow(($item['c5'] - $min_c5), 2) +
    //                     pow(($item['c6'] - $min_c6), 2) +
    //                     pow(($item['c7'] - $min_c7), 2) +
    //                     pow(($item['c8'] - $min_c8), 2)
    //             ),
    //             3
    //         );

    //         $hasil_final = number_format($hasil_negatif / ($hasil_negatif + $hasil_positif), 3);
    //         $hasil_akhir[] = [
    //             'nama' => $item['nama_pegawai'],
    //             'D+' => $hasil_positif,
    //             'D-' => $hasil_negatif,
    //             'skor_akhir' => $hasil_final
    //         ];
    //     }

    //     return view('hasil_akhir_topsis', ['data' => $hasil_akhir]);
    // }

    public function hasil_akhir()
    {

        $role = session('user')['role'];
        $divisiId = session('user')['divisi'];
        $periode = 2024; // Sesuaikan dengan periode yang diinginkan

        if ($role === "Kepala Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 3)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        } elseif ($role === "Kepala Sub Bagian") {
            $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                ->where('pegawai.divisi_id', $divisiId)
                ->where('pegawai.jabatan_id', 4)
                ->where('detail_penilaian.periode', $periode)
                ->get();
        }

        $kriteria = Criteria::all();

        // if ($penilaian->count() > 0) {

        $grouped_values = [];
        foreach ($penilaian as $item) {
            $criterion = $item->criteria;
            if (!isset($grouped_values[$criterion])) {
                $grouped_values[$criterion] = [];
            }
            $grouped_values[$criterion][] = $item->nilai;
        }

        // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
        $hasil_kuadrat = [];
        foreach ($grouped_values as $criterion => $values) {
            $sum_of_squares = 0;
            foreach ($values as $value) {
                $sum_of_squares += pow($value, 2);
            }
            $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
        }

        // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
        $normalisasi = [];
        foreach ($penilaian as $item) {
            $nama_pegawai = $item->nama_pegawai;
            if (!isset($normalisasi[$nama_pegawai])) {
                $normalisasi[$nama_pegawai] = [
                    'nama_pegawai' => $nama_pegawai,
                ];
            }

            $criterion = $item->criteria;
            $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
            $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
        }

        // Konversi normalisasi ke array indexed (bukan associative) untuk tampilan yang lebih mudah
        $normalisasi = array_values($normalisasi);

        // $kriteria = Criteria::all();
        $atribut_optimal = [];

        $nilai_criteria = $kriteria->pluck('weight')->toArray();
        $nama_kriteria = $kriteria->pluck('criteria')->toArray();

        foreach ($normalisasi as $item_normalisasi) {
            $atribut_optimal_item = ['nama_pegawai' => $item_normalisasi['nama_pegawai']];

            // Iterasi sesuai dengan jumlah kriteria
            for ($i = 0; $i < count($nama_kriteria); $i++) {
                $kriteria_key = 'C' . ($i + 1); // Nama kriteria (C1, C2, dst)
                $nilai_normalisasi = $item_normalisasi[$kriteria_key]; // Nilai normalisasi untuk kriteria saat ini
                $bobot = $nilai_criteria[$i]; // Bobot dari model Criteria untuk kriteria saat ini

                // Hitung atribut optimal dan simpan dalam array
                $atribut_optimal_item[$kriteria_key] = number_format($nilai_normalisasi * $bobot, 3);
            }

            // Tambahkan hasil perhitungan untuk satu pegawai ke dalam hasil akhir
            $atribut_optimal[] = $atribut_optimal_item;
        }

        // Debugging hasil atribut optimal
        // dd($atribut_optimal);

        // Inisialisasi solusi ideal
        $solusi_ideal = [
            "solusi_ideal_positif" => [],
            "solusi_ideal_negatif" => [],
        ];

        // Inisialisasi nilai maksimum dan minimum untuk setiap kriteria
        foreach ($kriteria as $k) {
            $solusi_ideal["solusi_ideal_positif"][$k->criteria] = -INF;
            $solusi_ideal["solusi_ideal_negatif"][$k->criteria] = INF;
        }

        // Menghitung nilai maksimum dan minimum untuk setiap kriteria
        foreach ($atribut_optimal as $item) {
            foreach ($kriteria as $k) {
                $criterion = $k->criteria;
                $solusi_ideal["solusi_ideal_positif"][$criterion] = max($solusi_ideal["solusi_ideal_positif"][$criterion], $item[$criterion]);
                $solusi_ideal["solusi_ideal_negatif"][$criterion] = min($solusi_ideal["solusi_ideal_negatif"][$criterion], $item[$criterion]);
            }
        }

        // Hasil solusi ideal
        $tipe_solusi_ideal = [
            "solusi ideal negatif",
            "solusi ideal positif"
        ];

        // dd($solusi_ideal);

        $hasil_akhir = [];

        // Menghitung hasil akhir
        foreach ($atribut_optimal as $item) {
            $hasil_positif = 0;
            $hasil_negatif = 0;

            foreach ($kriteria as $k) {
                $criterion = $k->criteria;
                $max_value = $solusi_ideal['solusi_ideal_positif'][$criterion];
                $min_value = $solusi_ideal['solusi_ideal_negatif'][$criterion];

                // Menghitung jarak positif dan negatif
                $hasil_positif += pow(($max_value - $item[$criterion]), 2);
                $hasil_negatif += pow(($item[$criterion] - $min_value), 2);
            }

            // Mengambil akar kuadrat dari hasil penjumlahan
            $hasil_positif = sqrt($hasil_positif);
            $hasil_negatif = sqrt($hasil_negatif);

            // Menghitung skor akhir
            $hasil_final = number_format($hasil_negatif / ($hasil_negatif + $hasil_positif), 3);

            // Menyimpan hasil akhir
            $hasil_akhir[] = [
                'nama' => $item['nama_pegawai'],
                'D+' => number_format($hasil_positif, 3),
                'D-' => number_format($hasil_negatif, 3),
                'skor_akhir' => $hasil_final
            ];
        }

        // dd($hasil_akhir);


        return view('hasil_akhir_topsis', ['data' => $hasil_akhir]);
    }

    // public function data_hasil_akhir($jabatan, $tahun, $individu)
    // {
    //     if ($tahun) {
    //         if (Session('user')['role'] === "Kepala Bagian") {
    //             $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
    //                 ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
    //                 ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
    //                 ->where('pegawai.divisi_id', Session('user')['divisi'])
    //                 ->where('pegawai.jabatan_id', 3)
    //                 ->where('periode', $tahun)
    //                 ->get();
    //         } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
    //             if ($individu == 'individu') {
    //                 $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
    //                     ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
    //                     ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
    //                     ->where('pegawai.divisi_id', Session('user')['divisi'])
    //                     ->where('pegawai.jabatan_id', 3)
    //                     ->where('periode', $tahun)
    //                     ->get();
    //                 // dd("halo");
    //             } else {
    //                 $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
    //                     ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
    //                     ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
    //                     ->where('pegawai.divisi_id', Session('user')['divisi'])
    //                     ->where('pegawai.jabatan_id', 4)
    //                     ->where('periode', $tahun)
    //                     ->get();
    //             }
    //         } elseif (Session('user')['role'] === "karyawan") {
    //             $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
    //                 ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
    //                 ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
    //                 ->where('pegawai.divisi_id', Session('user')['divisi'])
    //                 ->where('pegawai.jabatan_id', 4)
    //                 ->where('periode', $tahun)
    //                 ->get();
    //         } else {
    //             if ($jabatan) {
    //                 $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
    //                     ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
    //                     ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
    //                     ->where('pegawai.jabatan_id', $jabatan)
    //                     ->where('periode', $tahun)
    //                     ->get();
    //             }
    //         }

    //         $kriteria = Criteria::all();

    //         // dd($penilaian);
    //         $grouped_values = [];
    //         foreach ($penilaian as $item) {
    //             $criterion = $item->criteria;
    //             // dd($item);
    //             // dd($grouped_values[$criterion]);
    //             if (!isset($grouped_values[$criterion])) {
    //                 $grouped_values[$criterion] = [];
    //             }
    //             $grouped_values[$criterion][] = $item->nilai;
    //         }

    //         // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
    //         $hasil_kuadrat = [];
    //         foreach ($grouped_values as $criterion => $values) {
    //             $sum_of_squares = array_reduce($values, function ($carry, $value) {
    //                 return $carry + pow($value, 2);
    //             }, 0);
    //             $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
    //         }

    //         // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
    //         $normalisasi = [];
    //         foreach ($penilaian as $item) {
    //             $nama_pegawai = $item->nama_pegawai;
    //             if (!isset($normalisasi[$nama_pegawai])) {
    //                 $normalisasi[$nama_pegawai] = [
    //                     'nama_pegawai' => $nama_pegawai,
    //                 ];
    //             }

    //             $criterion = $item->criteria;
    //             $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
    //             $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
    //         }

    //         $normalisasi = array_values($normalisasi);

    //         $atribut_optimal = [];
    //         $nilai_criteria = $kriteria->pluck('weight', 'criteria')->toArray();

    //         foreach ($normalisasi as $item_normalisasi) {
    //             $atribut_optimal_item = ['nama_pegawai' => $item_normalisasi['nama_pegawai']];
    //             foreach ($nilai_criteria as $criterion => $weight) {
    //                 if (isset($item_normalisasi[$criterion])) {
    //                     $atribut_optimal_item[$criterion] = number_format($item_normalisasi[$criterion] * $weight, 3);
    //                 } else {
    //                     $atribut_optimal_item[$criterion] = 0;
    //                 }
    //             }
    //             $atribut_optimal[] = $atribut_optimal_item;
    //         }

    //         $solusi_ideal = [
    //             "solusi_ideal_positif" => [],
    //             "solusi_ideal_negatif" => [],
    //         ];

    //         foreach ($kriteria as $k) {
    //             $solusi_ideal["solusi_ideal_positif"][$k->criteria] = -INF;
    //             $solusi_ideal["solusi_ideal_negatif"][$k->criteria] = INF;
    //         }

    //         foreach ($atribut_optimal as $item) {
    //             foreach ($kriteria as $k) {
    //                 $criterion = $k->criteria;
    //                 $solusi_ideal["solusi_ideal_positif"][$criterion] = max($solusi_ideal["solusi_ideal_positif"][$criterion], $item[$criterion]);
    //                 $solusi_ideal["solusi_ideal_negatif"][$criterion] = min($solusi_ideal["solusi_ideal_negatif"][$criterion], $item[$criterion]);
    //             }
    //         }
    //         // dd($atribut_optimal);

    //         $hasil_akhir = [];

    //         foreach ($atribut_optimal as $item) {
    //             $hasil_positif = 0;
    //             $hasil_negatif = 0;

    //             foreach ($kriteria as $k) {
    //                 $criterion = $k->criteria;
    //                 $max_value = $solusi_ideal['solusi_ideal_positif'][$criterion];
    //                 $min_value = $solusi_ideal['solusi_ideal_negatif'][$criterion];

    //                 $hasil_positif += pow(($max_value - $item[$criterion]), 2);
    //                 $hasil_negatif += pow(($item[$criterion] - $min_value), 2);
    //             }

    //             $hasil_positif = sqrt($hasil_positif);
    //             $hasil_negatif = sqrt($hasil_negatif);

    //             $hasil_final = number_format($hasil_negatif / ($hasil_negatif + $hasil_positif), 3);

    //             $hasil_akhir[] = [
    //                 'nama' => $item['nama_pegawai'],
    //                 'D+' => number_format($hasil_positif, 3),
    //                 'D-' => number_format($hasil_negatif, 3),
    //                 'skor_akhir' => $hasil_final
    //             ];
    //         }

    //         usort($hasil_akhir, function ($a, $b) {
    //             return $b['skor_akhir'] <=> $a['skor_akhir'];
    //         });

    //         return $hasil_akhir;
    //     } else {
    //         return [];
    //     }
    // }

    public function data_hasil_akhir($jabatan, $tahun, $individu)
    {
        if ($tahun) {
            if (Session('user')['role'] === "Kepala Bagian") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 3)
                    ->where('periode', $tahun)
                    ->get();
            } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
                if ($individu == 'individu') {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 3)
                        ->where('periode', $tahun)
                        ->get();
                    // dd("halo");
                } else {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 4)
                        ->where('periode', $tahun)
                        ->get();
                }
            } elseif (Session('user')['role'] === "karyawan") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 4)
                    ->where('periode', $tahun)
                    ->get();
            } else {
                if ($jabatan) {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                        ->where('pegawai.jabatan_id', $jabatan)
                        ->where('periode', $tahun)
                        ->get();
                }
            }

            $kriteria = Criteria::all();

            // dd($penilaian);
            $grouped_values = [];
            foreach ($penilaian as $item) {
                $criterion = $item->criteria;
                // dd($item);
                // dd($grouped_values[$criterion]);
                if (!isset($grouped_values[$criterion])) {
                    $grouped_values[$criterion] = [];
                }
                $grouped_values[$criterion][] = $item->nilai;
            }

            // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
            $hasil_kuadrat = [];
            foreach ($grouped_values as $criterion => $values) {
                $sum_of_squares = array_reduce($values, function ($carry, $value) {
                    return $carry + pow($value, 2);
                }, 0);
                $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
            }

            // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
            $normalisasi = [];
            foreach ($penilaian as $item) {
                $nama_pegawai = $item->nama_pegawai;
                if (!isset($normalisasi[$nama_pegawai])) {
                    $normalisasi[$nama_pegawai] = [
                        'nama_pegawai' => $nama_pegawai,
                    ];
                }

                $criterion = $item->criteria;
                $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
                $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
            }

            $normalisasi = array_values($normalisasi);

            $atribut_optimal = [];
            $nilai_criteria = $kriteria->pluck('weight', 'criteria')->toArray();

            foreach ($normalisasi as $item_normalisasi) {
                $atribut_optimal_item = ['nama_pegawai' => $item_normalisasi['nama_pegawai']];
                foreach ($nilai_criteria as $criterion => $weight) {
                    if (isset($item_normalisasi[$criterion])) {
                        $atribut_optimal_item[$criterion] = number_format($item_normalisasi[$criterion] * $weight, 3);
                    } else {
                        $atribut_optimal_item[$criterion] = 0;
                    }
                }
                $atribut_optimal[] = $atribut_optimal_item;
            }

            $solusi_ideal = [
                "solusi_ideal_positif" => [],
                "solusi_ideal_negatif" => [],
            ];

            foreach ($kriteria as $k) {
                $solusi_ideal["solusi_ideal_positif"][$k->criteria] = -INF;
                $solusi_ideal["solusi_ideal_negatif"][$k->criteria] = INF;
            }

            foreach ($atribut_optimal as $item) {
                foreach ($kriteria as $k) {
                    $criterion = $k->criteria;
                    $solusi_ideal["solusi_ideal_positif"][$criterion] = max($solusi_ideal["solusi_ideal_positif"][$criterion], $item[$criterion]);
                    $solusi_ideal["solusi_ideal_negatif"][$criterion] = min($solusi_ideal["solusi_ideal_negatif"][$criterion], $item[$criterion]);
                }
            }
            // dd($atribut_optimal);

            $hasil_akhir = [];

            foreach ($atribut_optimal as $item) {
                $hasil_positif = 0;
                $hasil_negatif = 0;

                foreach ($kriteria as $k) {
                    $criterion = $k->criteria;
                    $max_value = $solusi_ideal['solusi_ideal_positif'][$criterion];
                    $min_value = $solusi_ideal['solusi_ideal_negatif'][$criterion];

                    $hasil_positif += pow(($max_value - $item[$criterion]), 2);
                    $hasil_negatif += pow(($item[$criterion] - $min_value), 2);
                }

                $hasil_positif = sqrt($hasil_positif);
                $hasil_negatif = sqrt($hasil_negatif);

                // Check if denominator is zero to avoid division by zero
                $denominator = $hasil_negatif + $hasil_positif;
                $hasil_final = $denominator != 0 ? number_format($hasil_negatif / $denominator, 3) : 0;

                $hasil_akhir[] = [
                    'nama' => $item['nama_pegawai'],
                    'D+' => number_format($hasil_positif, 3),
                    'D-' => number_format($hasil_negatif, 3),
                    'skor_akhir' => $hasil_final
                ];
            }

            usort($hasil_akhir, function ($a, $b) {
                return $b['skor_akhir'] <=> $a['skor_akhir'];
            });

            return $hasil_akhir;
        } else {
            return [];
        }
    }


    public function export_data_hasil_akhir($jabatan, $tahun, $individu)

    {

        if ($tahun) {
            if (Session('user')['role'] === "Kepala Bagian") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 3)
                    ->where('periode', $tahun)
                    ->get();
            } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
                if ($individu == 'individu') {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 3)
                        ->where('periode', $tahun)
                        ->get();
                    // dd("halo");
                } else {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                        ->where('pegawai.divisi_id', Session('user')['divisi'])
                        ->where('pegawai.jabatan_id', 4)
                        ->where('periode', $tahun)
                        ->get();
                }
            } elseif (Session('user')['role'] === "karyawan") {
                $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                    ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                    ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 4)
                    ->where('periode', $tahun)
                    ->get();
            } else {
                if ($jabatan) {
                    $penilaian = DetailPenilaian::join('pegawai', 'pegawai.id', '=', 'detail_penilaian.pegawai_id')
                        ->join('criterias', 'criterias.id', '=', 'detail_penilaian.criteria_id')
                        ->select('detail_penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'criterias.criteria')
                        ->where('pegawai.jabatan_id', $jabatan)
                        ->where('periode', $tahun)
                        ->get();
                }
            }

            $kriteria = Criteria::all();

            // dd($penilaian);
            $grouped_values = [];
            foreach ($penilaian as $item) {
                $criterion = $item->criteria;
                // dd($item);
                // dd($grouped_values[$criterion]);
                if (!isset($grouped_values[$criterion])) {
                    $grouped_values[$criterion] = [];
                }
                $grouped_values[$criterion][] = $item->nilai;
            }

            // Menghitung jumlah kuadrat dan akar kuadrat untuk setiap kriteria
            $hasil_kuadrat = [];
            foreach ($grouped_values as $criterion => $values) {
                $sum_of_squares = array_reduce($values, function ($carry, $value) {
                    return $carry + pow($value, 2);
                }, 0);
                $hasil_kuadrat[$criterion] = sqrt($sum_of_squares);
            }

            // Menghitung normalisasi untuk setiap pegawai dan setiap kriteria
            $normalisasi = [];
            foreach ($penilaian as $item) {
                $nama_pegawai = $item->nama_pegawai;
                if (!isset($normalisasi[$nama_pegawai])) {
                    $normalisasi[$nama_pegawai] = [
                        'nama_pegawai' => $nama_pegawai,
                    ];
                }

                $criterion = $item->criteria;
                $normalized_value = $hasil_kuadrat[$criterion] != 0 ? number_format($item->nilai / $hasil_kuadrat[$criterion], 3) : 0;
                $normalisasi[$nama_pegawai][$criterion] = $normalized_value;
            }

            $normalisasi = array_values($normalisasi);

            $atribut_optimal = [];
            $nilai_criteria = $kriteria->pluck('weight', 'criteria')->toArray();

            foreach ($normalisasi as $item_normalisasi) {
                $atribut_optimal_item = ['nama_pegawai' => $item_normalisasi['nama_pegawai']];
                foreach ($nilai_criteria as $criterion => $weight) {
                    if (isset($item_normalisasi[$criterion])) {
                        $atribut_optimal_item[$criterion] = number_format($item_normalisasi[$criterion] * $weight, 3);
                    } else {
                        $atribut_optimal_item[$criterion] = 0;
                    }
                }
                $atribut_optimal[] = $atribut_optimal_item;
            }

            $solusi_ideal = [
                "solusi_ideal_positif" => [],
                "solusi_ideal_negatif" => [],
            ];

            foreach ($kriteria as $k) {
                $solusi_ideal["solusi_ideal_positif"][$k->criteria] = -INF;
                $solusi_ideal["solusi_ideal_negatif"][$k->criteria] = INF;
            }

            foreach ($atribut_optimal as $item) {
                foreach ($kriteria as $k) {
                    $criterion = $k->criteria;
                    $solusi_ideal["solusi_ideal_positif"][$criterion] = max($solusi_ideal["solusi_ideal_positif"][$criterion], $item[$criterion]);
                    $solusi_ideal["solusi_ideal_negatif"][$criterion] = min($solusi_ideal["solusi_ideal_negatif"][$criterion], $item[$criterion]);
                }
            }
            // dd($atribut_optimal);

            $hasil_akhir = [];

            foreach ($atribut_optimal as $item) {
                $hasil_positif = 0;
                $hasil_negatif = 0;

                foreach ($kriteria as $k) {
                    $criterion = $k->criteria;
                    $max_value = $solusi_ideal['solusi_ideal_positif'][$criterion];
                    $min_value = $solusi_ideal['solusi_ideal_negatif'][$criterion];

                    $hasil_positif += pow(($max_value - $item[$criterion]), 2);
                    $hasil_negatif += pow(($item[$criterion] - $min_value), 2);
                }

                $hasil_positif = sqrt($hasil_positif);
                $hasil_negatif = sqrt($hasil_negatif);

                // Check if denominator is zero to avoid division by zero
                $denominator = $hasil_negatif + $hasil_positif;
                $hasil_final = $denominator != 0 ? number_format($hasil_negatif / $denominator, 3) : 0;

                $hasil_akhir[] = [
                    'nama' => $item['nama_pegawai'],
                    'D+' => number_format($hasil_positif, 3),
                    'D-' => number_format($hasil_negatif, 3),
                    'skor_akhir' => $hasil_final
                ];
            }

            usort($hasil_akhir, function ($a, $b) {
                return $b['skor_akhir'] <=> $a['skor_akhir'];
            });

            return $hasil_akhir;
        } else {
            return [];
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}
