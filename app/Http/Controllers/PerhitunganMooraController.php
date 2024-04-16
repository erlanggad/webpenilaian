<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
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

        $jumlah_kuadrat_c1 = 0;
        $jumlah_kuadrat_c2 = 0;
        $jumlah_kuadrat_c3 = 0;
        $jumlah_kuadrat_c4 = 0;
        $jumlah_kuadrat_c5 = 0;
        $jumlah_kuadrat_c6 = 0;
        $jumlah_kuadrat_c7 = 0;
        $jumlah_kuadrat_c8 = 0;


        foreach ($penilaian as $item) {
            // Hitung jumlah kuadrat dari nilai-nilai
            $jumlah_kuadrat_c1 += pow($item->c1, 2);
            $jumlah_kuadrat_c2 += pow($item->c2, 2);
            $jumlah_kuadrat_c3 += pow($item->c3, 2);
            $jumlah_kuadrat_c4 += pow($item->c4, 2);
            $jumlah_kuadrat_c5 += pow($item->c5, 2);
            $jumlah_kuadrat_c6 += pow($item->c6, 2);
            $jumlah_kuadrat_c7 += pow($item->c7, 2);
            $jumlah_kuadrat_c8 += pow($item->c8, 2);
        }

        // Hitung akar kuadrat dari jumlah kuadrat
        $hasil_c1 = sqrt($jumlah_kuadrat_c1);
        $hasil_c2 = sqrt($jumlah_kuadrat_c2);
        $hasil_c3 = sqrt($jumlah_kuadrat_c3);
        $hasil_c4 = sqrt($jumlah_kuadrat_c4);
        $hasil_c5 = sqrt($jumlah_kuadrat_c5);
        $hasil_c6 = sqrt($jumlah_kuadrat_c6);
        $hasil_c7 = sqrt($jumlah_kuadrat_c7);
        $hasil_c8 = sqrt($jumlah_kuadrat_c8);



        $normalisasi = [];

        foreach ($penilaian as $item) {
            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                "c1" => number_format($item->c1 / $hasil_c1, 3),
                "c2" => number_format($item->c2 / $hasil_c2, 3),
                "c3" => number_format($item->c3 / $hasil_c3, 3),
                "c4" => number_format($item->c4 / $hasil_c4, 3),
                "c5" => number_format($item->c5 / $hasil_c5, 3),
                "c6" => number_format($item->c6 / $hasil_c6, 3),
                "c7" => number_format($item->c7 / $hasil_c7, 3),
                "c8" => number_format($item->c8 / $hasil_c8, 3),
            ];
        }


        return view('normalisasi_penilaian_moora', ['data' => $normalisasi]);
    }

    public function hasil_atribut_optimal()
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

        $jumlah_kuadrat_c1 = 0;
        $jumlah_kuadrat_c2 = 0;
        $jumlah_kuadrat_c3 = 0;
        $jumlah_kuadrat_c4 = 0;
        $jumlah_kuadrat_c5 = 0;
        $jumlah_kuadrat_c6 = 0;
        $jumlah_kuadrat_c7 = 0;
        $jumlah_kuadrat_c8 = 0;


        foreach ($penilaian as $item) {
            // Hitung jumlah kuadrat dari nilai-nilai
            $jumlah_kuadrat_c1 += pow($item->c1, 2);
            $jumlah_kuadrat_c2 += pow($item->c2, 2);
            $jumlah_kuadrat_c3 += pow($item->c3, 2);
            $jumlah_kuadrat_c4 += pow($item->c4, 2);
            $jumlah_kuadrat_c5 += pow($item->c5, 2);
            $jumlah_kuadrat_c6 += pow($item->c6, 2);
            $jumlah_kuadrat_c7 += pow($item->c7, 2);
            $jumlah_kuadrat_c8 += pow($item->c8, 2);
        }

        // Hitung akar kuadrat dari jumlah kuadrat
        $hasil_c1 = sqrt($jumlah_kuadrat_c1);
        $hasil_c2 = sqrt($jumlah_kuadrat_c2);
        $hasil_c3 = sqrt($jumlah_kuadrat_c3);
        $hasil_c4 = sqrt($jumlah_kuadrat_c4);
        $hasil_c5 = sqrt($jumlah_kuadrat_c5);
        $hasil_c6 = sqrt($jumlah_kuadrat_c6);
        $hasil_c7 = sqrt($jumlah_kuadrat_c7);
        $hasil_c8 = sqrt($jumlah_kuadrat_c8);



        $normalisasi = [];

        foreach ($penilaian as $item) {
            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                "c1" => number_format($item->c1 / number_format($hasil_c1, 1), 3),
                "c2" => number_format($item->c2 / number_format($hasil_c2, 1), 3),
                "c3" => number_format($item->c3 / number_format($hasil_c3, 1), 3),
                "c4" => number_format($item->c4 / number_format($hasil_c4, 1), 3),
                "c5" => number_format($item->c5 / number_format($hasil_c5, 1), 3),
                "c6" => number_format($item->c6 / number_format($hasil_c6, 1), 3),
                "c7" => number_format($item->c7 / number_format($hasil_c7, 1), 3),
                "c8" => number_format($item->c8 / number_format($hasil_c8, 1), 3),
            ];
        }

        $kriteria = Criteria::all();
        $atribut_optimal = [];

        foreach ($normalisasi as $item_normalisasi) {
            $nilai_criteria = $kriteria->pluck('weight');
            // dd($item_normalisasi['c1']);
            $atribut_optimal[] = [
                'nama_pegawai' => $item_normalisasi['nama_pegawai'],
                // "c1 normalisasi" => $item_normalisasi['c1'],
                "c1" => number_format($item_normalisasi['c1'] * $nilai_criteria[0], 3),
                "c2" => number_format($item_normalisasi['c2'] * $nilai_criteria[1], 3),
                "c3" => number_format($item_normalisasi['c3'] * $nilai_criteria[2], 3),
                "c4" => number_format($item_normalisasi['c4'] * $nilai_criteria[3], 3),
                "c5" => number_format($item_normalisasi['c5'] * $nilai_criteria[4], 3),
                "c6" => number_format($item_normalisasi['c6'] * $nilai_criteria[5], 3),
                "c7" => number_format($item_normalisasi['c7'] * $nilai_criteria[6], 3),
                "c8" => number_format($item_normalisasi['c8'] * $nilai_criteria[7], 3),
            ];
        }
        //   dd($atribut_optimal);

        return view('atribut_optimal_penilaian_moora', ['data' => $atribut_optimal]);
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

        $jumlah_kuadrat_c1 = 0;
        $jumlah_kuadrat_c2 = 0;
        $jumlah_kuadrat_c3 = 0;
        $jumlah_kuadrat_c4 = 0;
        $jumlah_kuadrat_c5 = 0;
        $jumlah_kuadrat_c6 = 0;
        $jumlah_kuadrat_c7 = 0;
        $jumlah_kuadrat_c8 = 0;


        foreach ($penilaian as $item) {
            // Hitung jumlah kuadrat dari nilai-nilai
            $jumlah_kuadrat_c1 += pow($item->c1, 2);
            $jumlah_kuadrat_c2 += pow($item->c2, 2);
            $jumlah_kuadrat_c3 += pow($item->c3, 2);
            $jumlah_kuadrat_c4 += pow($item->c4, 2);
            $jumlah_kuadrat_c5 += pow($item->c5, 2);
            $jumlah_kuadrat_c6 += pow($item->c6, 2);
            $jumlah_kuadrat_c7 += pow($item->c7, 2);
            $jumlah_kuadrat_c8 += pow($item->c8, 2);
        }

        // Hitung akar kuadrat dari jumlah kuadrat
        $hasil_c1 = sqrt($jumlah_kuadrat_c1);
        $hasil_c2 = sqrt($jumlah_kuadrat_c2);
        $hasil_c3 = sqrt($jumlah_kuadrat_c3);
        $hasil_c4 = sqrt($jumlah_kuadrat_c4);
        $hasil_c5 = sqrt($jumlah_kuadrat_c5);
        $hasil_c6 = sqrt($jumlah_kuadrat_c6);
        $hasil_c7 = sqrt($jumlah_kuadrat_c7);
        $hasil_c8 = sqrt($jumlah_kuadrat_c8);



        $normalisasi = [];

        foreach ($penilaian as $item) {
            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                "c1" => number_format($item->c1 / number_format($hasil_c1, 1), 3),
                "c2" => number_format($item->c2 / number_format($hasil_c2, 1), 3),
                "c3" => number_format($item->c3 / number_format($hasil_c3, 1), 3),
                "c4" => number_format($item->c4 / number_format($hasil_c4, 1), 3),
                "c5" => number_format($item->c5 / number_format($hasil_c5, 1), 3),
                "c6" => number_format($item->c6 / number_format($hasil_c6, 1), 3),
                "c7" => number_format($item->c7 / number_format($hasil_c7, 1), 3),
                "c8" => number_format($item->c8 / number_format($hasil_c8, 1), 3),
            ];
        }

        $kriteria = Criteria::all();
        $atribut_optimal = [];

        foreach ($normalisasi as $item_normalisasi) {
            $nilai_criteria = $kriteria->pluck('weight');
            // dd($item_normalisasi['c1']);
            $atribut_optimal[] = [
                'nama_pegawai' => $item_normalisasi['nama_pegawai'],
                // "c1 normalisasi" => $item_normalisasi['c1'],
                "c1" => number_format($item_normalisasi['c1'] * $nilai_criteria[0], 3),
                "c2" => number_format($item_normalisasi['c2'] * $nilai_criteria[1], 3),
                "c3" => number_format($item_normalisasi['c3'] * $nilai_criteria[2], 3),
                "c4" => number_format($item_normalisasi['c4'] * $nilai_criteria[3], 3),
                "c5" => number_format($item_normalisasi['c5'] * $nilai_criteria[4], 3),
                "c6" => number_format($item_normalisasi['c6'] * $nilai_criteria[5], 3),
                "c7" => number_format($item_normalisasi['c7'] * $nilai_criteria[6], 3),
                "c8" => number_format($item_normalisasi['c8'] * $nilai_criteria[7], 3),
            ];
        }

        $hasil_akhir = [];

        foreach ($atribut_optimal as $item) {
            // Menghitung hasil akhir dari penjumlahan c1 sampai c8
            $total = $item['c1'] + $item['c2'] + $item['c3'] + $item['c4'] + $item['c5'] + $item['c6'] + $item['c7'] + $item['c8'];

            // Menyimpan hasil akhir dalam variabel baru
            $hasil_akhir[] = [
                'nama' => $item['nama_pegawai'],
                'skor_akhir' => number_format($total, 3)
            ];
        }

        return view('hasil_akhir_moora', ['data' => $hasil_akhir]);
        // } else {

        //     $hasil_akhir = [];

        //     $role['role'] = Session('user')['role'];

        //     return view('hasil_akhir_pengajuan_cuti_non', ['data' => $hasil_akhir, 'role' => $role]);
        // }
    }

    public function data_hasil_akhir($tahun)
    {

        // dd($tahun);
        if ($tahun) {
            if (Session('user')['role'] === "Kepala Bagian") {
                $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                    ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 3)
                    ->where('periode', $tahun)
                    ->get();
            } elseif (Session('user')['role'] === "Kepala Sub Bagian") {
                $penilaian = Penilaian::join('pegawai', 'pegawai.id', '=', 'penilaian.pegawai_id')
                    ->select('penilaian.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk')
                    ->where('pegawai.divisi_id', Session('user')['divisi'])
                    ->where('pegawai.jabatan_id', 4)
                    ->where('periode', $tahun)
                    ->get();
            }

            $jumlah_kuadrat_c1 = 0;
            $jumlah_kuadrat_c2 = 0;
            $jumlah_kuadrat_c3 = 0;
            $jumlah_kuadrat_c4 = 0;
            $jumlah_kuadrat_c5 = 0;
            $jumlah_kuadrat_c6 = 0;
            $jumlah_kuadrat_c7 = 0;
            $jumlah_kuadrat_c8 = 0;


            foreach ($penilaian as $item) {
                // Hitung jumlah kuadrat dari nilai-nilai
                $jumlah_kuadrat_c1 += pow($item->c1, 2);
                $jumlah_kuadrat_c2 += pow($item->c2, 2);
                $jumlah_kuadrat_c3 += pow($item->c3, 2);
                $jumlah_kuadrat_c4 += pow($item->c4, 2);
                $jumlah_kuadrat_c5 += pow($item->c5, 2);
                $jumlah_kuadrat_c6 += pow($item->c6, 2);
                $jumlah_kuadrat_c7 += pow($item->c7, 2);
                $jumlah_kuadrat_c8 += pow($item->c8, 2);
            }

            // Hitung akar kuadrat dari jumlah kuadrat
            $hasil_c1 = sqrt($jumlah_kuadrat_c1);
            $hasil_c2 = sqrt($jumlah_kuadrat_c2);
            $hasil_c3 = sqrt($jumlah_kuadrat_c3);
            $hasil_c4 = sqrt($jumlah_kuadrat_c4);
            $hasil_c5 = sqrt($jumlah_kuadrat_c5);
            $hasil_c6 = sqrt($jumlah_kuadrat_c6);
            $hasil_c7 = sqrt($jumlah_kuadrat_c7);
            $hasil_c8 = sqrt($jumlah_kuadrat_c8);



            $normalisasi = [];

            foreach ($penilaian as $item) {
                $normalisasi[] = [
                    'nama_pegawai' => $item['nama_pegawai'],
                    "c1" => number_format($item->c1 / number_format($hasil_c1, 1), 3),
                    "c2" => number_format($item->c2 / number_format($hasil_c2, 1), 3),
                    "c3" => number_format($item->c3 / number_format($hasil_c3, 1), 3),
                    "c4" => number_format($item->c4 / number_format($hasil_c4, 1), 3),
                    "c5" => number_format($item->c5 / number_format($hasil_c5, 1), 3),
                    "c6" => number_format($item->c6 / number_format($hasil_c6, 1), 3),
                    "c7" => number_format($item->c7 / number_format($hasil_c7, 1), 3),
                    "c8" => number_format($item->c8 / number_format($hasil_c8, 1), 3),
                ];
            }

            $kriteria = Criteria::all();
            $atribut_optimal = [];

            foreach ($normalisasi as $item_normalisasi) {
                $nilai_criteria = $kriteria->pluck('weight');
                // dd($item_normalisasi['c1']);
                $atribut_optimal[] = [
                    'nama_pegawai' => $item_normalisasi['nama_pegawai'],
                    // "c1 normalisasi" => $item_normalisasi['c1'],
                    "c1" => number_format($item_normalisasi['c1'] * $nilai_criteria[0], 3),
                    "c2" => number_format($item_normalisasi['c2'] * $nilai_criteria[1], 3),
                    "c3" => number_format($item_normalisasi['c3'] * $nilai_criteria[2], 3),
                    "c4" => number_format($item_normalisasi['c4'] * $nilai_criteria[3], 3),
                    "c5" => number_format($item_normalisasi['c5'] * $nilai_criteria[4], 3),
                    "c6" => number_format($item_normalisasi['c6'] * $nilai_criteria[5], 3),
                    "c7" => number_format($item_normalisasi['c7'] * $nilai_criteria[6], 3),
                    "c8" => number_format($item_normalisasi['c8'] * $nilai_criteria[7], 3),
                ];
            }

            $hasil_akhir = [];

            foreach ($atribut_optimal as $item) {
                // Menghitung hasil akhir dari penjumlahan c1 sampai c8
                $total = $item['c1'] + $item['c2'] + $item['c3'] + $item['c4'] + $item['c5'] + $item['c6'] + $item['c7'] + $item['c8'];

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
