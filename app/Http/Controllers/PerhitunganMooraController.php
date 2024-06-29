<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\DetailPenilaian;
use App\Models\Pengajuan_cuti;
use App\Models\Pengajuan_cuti_non;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PerhitunganMooraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($jenis);

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

    //     dd($normalisasi);

    //     return view('normalisasi_penilaian_moora', ['data' => $normalisasi]);
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


        return view('normalisasi_penilaian_moora', compact('normalisasi', 'kriteria'));
    }

    // public function hasil_atribut_optimal()
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

    //     return view('atribut_optimal_penilaian_moora', ['data' => $atribut_optimal]);
    // }

    public function hasil_atribut_optimal()
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

        return view('atribut_optimal_penilaian_moora', compact('atribut_optimal', 'kriteria'));
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

    //     $hasil_akhir = [];

    //     foreach ($atribut_optimal as $item) {
    //         // Menghitung hasil akhir dari penjumlahan c1 sampai c8
    //         $total = $item['c1'] + $item['c2'] + $item['c3'] + $item['c4'] + $item['c5'] + $item['c6'] + $item['c7'] + $item['c8'];

    //         // Menyimpan hasil akhir dalam variabel baru
    //         $hasil_akhir[] = [
    //             'nama' => $item['nama_pegawai'],
    //             'skor_akhir' => number_format($total, 3)
    //         ];
    //     }

    //     return view('hasil_akhir_moora', ['data' => $hasil_akhir]);
    //     // } else {

    //     //     $hasil_akhir = [];

    //     //     $role['role'] = Session('user')['role'];

    //     //     return view('hasil_akhir_pengajuan_cuti_non', ['data' => $hasil_akhir, 'role' => $role]);
    //     // }
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

        $hasil_akhir = [];

        foreach ($atribut_optimal as $item) {
            $total = 0;

            // Iterasi melalui semua kriteria dan hitung totalnya
            foreach ($nama_kriteria as $index => $criterion) {
                $kriteria_key = 'C' . ($index + 1); // Membentuk nama kriteria dinamis (C1, C2, dst)
                $total += $item[$kriteria_key]; // Menambahkan nilai atribut optimal ke total
            }

            // Menyimpan hasil akhir dalam variabel baru
            $hasil_akhir[] = [
                'nama' => $item['nama_pegawai'],
                'skor_akhir' => number_format($total, 3)
            ];
        }

        // Debugging hasil akhir
        // dd($hasil_akhir);

        return view('hasil_akhir_moora', ['data' => $hasil_akhir]);
        // } else {

        //     $hasil_akhir = [];

        //     $role['role'] = Session('user')['role'];

        //     return view('hasil_akhir_pengajuan_cuti_non', ['data' => $hasil_akhir, 'role' => $role]);
        // }
    }
    public function data_hasil_akhir($jabatan, $tahun, $individu)
    {

        // dd($jabatan);
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

            $hasil_akhir = [];

            foreach ($atribut_optimal as $item) {
                $total = 0;

                // Iterasi melalui semua kriteria dan hitung totalnya
                foreach ($nama_kriteria as $index => $criterion) {
                    $kriteria_key = 'C' . ($index + 1); // Membentuk nama kriteria dinamis (C1, C2, dst)
                    $total += $item[$kriteria_key]; // Menambahkan nilai atribut optimal ke total
                }

                // Menyimpan hasil akhir dalam variabel baru
                $hasil_akhir[] = [
                    'nama' => $item['nama_pegawai'],
                    'skor_akhir' => number_format($total, 3)
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

        // dd($jabatan);
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

            $hasil_akhir = [];

            foreach ($atribut_optimal as $item) {
                $total = 0;

                // Iterasi melalui semua kriteria dan hitung totalnya
                foreach ($nama_kriteria as $index => $criterion) {
                    $kriteria_key = 'C' . ($index + 1); // Membentuk nama kriteria dinamis (C1, C2, dst)
                    $total += $item[$kriteria_key]; // Menambahkan nilai atribut optimal ke total
                }

                // Menyimpan hasil akhir dalam variabel baru
                $hasil_akhir[] = [
                    'nama' => $item['nama_pegawai'],
                    'skor_akhir' => number_format($total, 3)
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
