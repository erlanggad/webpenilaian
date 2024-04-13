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
        //     // Update nilai maksimum untuk setiap kriteria
        //     $max_c1 = max($max_c1, $item->c1);
        //     $max_c2 = max($max_c2, $item->c2);
        //     $max_c3 = max($max_c3, $item->c3);
        //     $max_c4 = max($max_c4, $item->c4);
        //     $max_c5 = max($max_c5, $item->c5);
        //     $max_c6 = max($max_c6, $item->c6);
        //     $max_c7 = max($max_c7, $item->c7);
        //     $max_c8 = max($max_c8, $item->c8);




        //     // dd($item->c1);
        // }

        // foreach ($penilaian as $item) {
        //     // Menghitung nilai $Rij_satu sampai $Rij_empat
        //     $Rij_satu = $item->c1 / $max_c1;
        //     $Rij_dua = $item->c2 / $max_c2;
        //     $Rij_tiga = $item->c3 / $max_c3;
        //     $Rij_empat = $item->c4 / $max_c4;
        //     $Rij_lima = $item->c5 / $max_c5;
        //     $Rij_enam = $item->c6 / $max_c6;
        //     $Rij_tujuh = $item->c7 / $max_c7;
        //     $Rij_delapan = $item->c8 / $max_c8;

        //     $normalisasi[] = [
        //         'nama_pegawai' => $item['nama_pegawai'],
        //         'Rij_satu' => number_format($Rij_satu, 3),
        //         'Rij_dua' => number_format($Rij_dua, 3),
        //         'Rij_tiga' => number_format($Rij_tiga, 3),
        //         'Rij_empat' => number_format($Rij_empat, 3),
        //         'Rij_lima' => number_format($Rij_lima, 3),
        //         'Rij_enam' => number_format($Rij_enam, 3),
        //         'Rij_tujuh' => number_format($Rij_tujuh, 3),
        //         'Rij_delapan' => number_format($Rij_delapan, 3)
        //     ];
        // }
        // dd($max_c1);

        // dd($normalisasi);




        return view('normalisasi_penilaian_moora', ['data' => $normalisasi]);
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
                'sum q1' =>$item2['Rij_satu'] * $nilai_criteria[0] + $item2['Rij_dua'] * $nilai_criteria[1] + $item2['Rij_tiga'] * $nilai_criteria[2] + $item2['Rij_empat'] * $nilai_criteria[3] + $item2['Rij_lima'] * $nilai_criteria[4] + $item2['Rij_enam'] * $nilai_criteria[5] + $item2['Rij_tujuh'] * $nilai_criteria[6] + $item2['Rij_delapan'] * $nilai_criteria[7],
                
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
