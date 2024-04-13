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

            $kriteria = Criteria::all();
            // $penilaian = Pengajuan_cuti_non::join('pegawai', 'pegawai.id', '=', 'cuti_non.pegawai_id')
            //     ->join('urgensi_cuti', 'urgensi_cuti.id', '=', 'cuti_non.urgensi_cuti_id')
            //     ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')->where('cuti_non.divisi_id', Session('user')['divisi'])
            //     ->get();
            // } else {
            //     $penilaian = Pengajuan_cuti_non::join('pegawai', 'pegawai.id', '=', 'cuti_non.pegawai_id')
            //         ->join('urgensi_cuti', 'urgensi_cuti.id', '=', 'cuti_non.urgensi_cuti_id')
            //         ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk', 'urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')
            //         ->get();
        }
        // dd($penilaian);

        $data['penilaian'] = $penilaian;
        $data['kriteria'] = $kriteria;
        // foreach ($penilaian as $penilaians) {
        //     $tahunMasuk = (new \DateTime($penilaians->tgl_pegawai_masuk))->format('Y');
        //     $tahunSekarang = (new \DateTime())->format('Y');

        //     // Menghitung k3 sesuai ketentuan
        //     $tahunDiff = $tahunSekarang - $tahunMasuk;
        //     if ($tahunDiff > 5) {
        //         $k3 = 4;
        //     } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
        //         $k3 = 3;
        //     } elseif ($tahunDiff == 3) {
        //         $k3 = 2;
        //     } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
        //         $k3 = 1;
        //     } else {
        //         $k3 = 0; // Jika tidak sesuai kondisi di atas
        //     }

        //     // Menghitung k2 sesuai ketentuan
        //     $sisaCuti = $penilaians->sisa_cuti;
        //     if ($sisaCuti > 5) {
        //         $k2 = 4;
        //     } elseif ($sisaCuti == 4) {
        //         $k2 = 3;
        //     } elseif ($sisaCuti == 3) {
        //         $k2 = 2;
        //     } elseif ($sisaCuti >= 1 && $sisaCuti <= 2) {
        //         $k2 = 1;
        //     } else {
        //         $k2 = 0; // Jika tidak sesuai kondisi di atas
        //     }

        //     // Menghitung k4 sesuai ketentuan
        //     $lamaCuti = $penilaians->lama_cuti;
        //     if ($lamaCuti == 1) {
        //         $k4 = 4;
        //     } elseif ($lamaCuti == 2) {
        //         $k4 = 3;
        //     } elseif ($lamaCuti == 3) {
        //         $k4 = 2;
        //     } elseif ($lamaCuti > 3) {
        //         $k4 = 1;
        //     } else {
        //         $k4 = 0; // Jika tidak sesuai kondisi di atas
        //     }

        //     $data[] = [
        //         'nama_pegawai' => $penilaians->nama_pegawai,
        //         'k1' => $penilaians->nilai,
        //         'k2' => $k2,
        //         'k3' => $k3,
        //         'k4' => $k4
        //     ];
        // }
        //     $roc = new RankOrderCentroidController();
        //     $criteriaWeight = $roc->criteriaWeight();

        //     return view('admin.criteria.index', compact('criterias', 'criteriaWeight'));
        // }
        // dd($data);
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
        return view('hasil_akhir_moora', ['data' => $hasil_akhir]);
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
