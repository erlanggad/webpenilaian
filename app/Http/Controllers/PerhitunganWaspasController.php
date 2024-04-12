<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Pengajuan_cuti;
use App\Models\Pengajuan_cuti_non;
use Illuminate\Http\Request;

class PerhitunganWaspasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($jenis)
    {
        // dd($jenis);
       if($jenis == 'tahunan'){



        $pengajuanCutis = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')
        ->join('urgensi_cuti', 'urgensi_cuti.id','=','pengajuan_cuti.urgensi_cuti_id')
        ->select('pengajuan_cuti.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')
        ->get();

    $data = [];
    foreach ($pengajuanCutis as $pengajuanCuti) {
        $tahunMasuk = (new \DateTime($pengajuanCuti->tgl_pegawai_masuk))->format('Y');
        $tahunSekarang = (new \DateTime())->format('Y');

        // Menghitung k3 sesuai ketentuan
        $tahunDiff = $tahunSekarang - $tahunMasuk;
        if ($tahunDiff > 5) {
            $k3 = 4;
        } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
            $k3 = 3;
        } elseif ($tahunDiff == 3) {
            $k3 = 2;
        } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
            $k3 = 1;
        } else {
            $k3 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k2 sesuai ketentuan
        $sisaCuti = $pengajuanCuti->sisa_cuti;
        if ($sisaCuti > 5) {
            $k2 = 4;
        } elseif ($sisaCuti == 4) {
            $k2 = 3;
        } elseif ($sisaCuti == 3) {
            $k2 = 2;
        } elseif ($sisaCuti >= 1 && $sisaCuti <= 2) {
            $k2 = 1;
        } else {
            $k2 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k4 sesuai ketentuan
        $lamaCuti = $pengajuanCuti->lama_cuti;
        if ($lamaCuti == 1) {
            $k4 = 4;
        } elseif ($lamaCuti == 2) {
            $k4 = 3;
        } elseif ($lamaCuti == 3) {
            $k4 = 2;
        } elseif ($lamaCuti > 3) {
            $k4 = 1;
        } else {
            $k4 = 0; // Jika tidak sesuai kondisi di atas
        }

        $data[] = [
            'nama_pegawai' => $pengajuanCuti->nama_pegawai,
            'k1' => $pengajuanCuti->nilai,
            'k2' => $k2,
            'k3' => $k3,
            'k4' => $k4
        ];
    }
        //     $roc = new RankOrderCentroidController();
        //     $criteriaWeight = $roc->criteriaWeight();

        //     return view('admin.criteria.index', compact('criterias', 'criteriaWeight'));
        // }
        // dd($data);
        return view('konversi_pengajuan_cuti', ['data' => $data]);
    }else if($jenis == "non-tahunan"){
        if(Session('user')['role'] === "Manager"){
            $pengajuanCutis = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
            ->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
            ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')->where('cuti_non.divisi_id', Session('user')['divisi'])
            ->get();
            }else{
                $pengajuanCutis = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
                ->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
                ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')
                ->get();
            }

    $data = [];
    foreach ($pengajuanCutis as $pengajuanCuti) {
        $tahunMasuk = (new \DateTime($pengajuanCuti->tgl_pegawai_masuk))->format('Y');
        $tahunSekarang = (new \DateTime())->format('Y');

        // Menghitung k3 sesuai ketentuan
        $tahunDiff = $tahunSekarang - $tahunMasuk;
        if ($tahunDiff > 5) {
            $k3 = 4;
        } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
            $k3 = 3;
        } elseif ($tahunDiff == 3) {
            $k3 = 2;
        } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
            $k3 = 1;
        } else {
            $k3 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k2 sesuai ketentuan
        $sisaCuti = $pengajuanCuti->sisa_cuti;
        if ($sisaCuti > 5) {
            $k2 = 4;
        } elseif ($sisaCuti == 4) {
            $k2 = 3;
        } elseif ($sisaCuti == 3) {
            $k2 = 2;
        } elseif ($sisaCuti >= 1 && $sisaCuti <= 2) {
            $k2 = 1;
        } else {
            $k2 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k4 sesuai ketentuan
        $lamaCuti = $pengajuanCuti->lama_cuti;
        if ($lamaCuti == 1) {
            $k4 = 4;
        } elseif ($lamaCuti == 2) {
            $k4 = 3;
        } elseif ($lamaCuti == 3) {
            $k4 = 2;
        } elseif ($lamaCuti > 3) {
            $k4 = 1;
        } else {
            $k4 = 0; // Jika tidak sesuai kondisi di atas
        }

        $data[] = [
            'nama_pegawai' => $pengajuanCuti->nama_pegawai,
            'k1' => $pengajuanCuti->nilai,
            'k2' => $k2,
            'k3' => $k3,
            'k4' => $k4
        ];
    }
        //     $roc = new RankOrderCentroidController();
        //     $criteriaWeight = $roc->criteriaWeight();

        //     return view('admin.criteria.index', compact('criterias', 'criteriaWeight'));
        // }
        // dd($data);
        return view('konversi_pengajuan_cuti', ['data' => $data]);
    }
}

    public function normalisasi($jenis)
    {
       if($jenis == 'tahunan'){



        $pengajuanCutis = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')
        ->join('urgensi_cuti', 'urgensi_cuti.id','=','pengajuan_cuti.urgensi_cuti_id')
        ->select('pengajuan_cuti.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')
        ->get();

    $data = [];
    foreach ($pengajuanCutis as $pengajuanCuti) {
        $tahunMasuk = (new \DateTime($pengajuanCuti->tgl_pegawai_masuk))->format('Y');
        $tahunSekarang = (new \DateTime())->format('Y');

        // Menghitung k3 sesuai ketentuan
        $tahunDiff = $tahunSekarang - $tahunMasuk;
        if ($tahunDiff > 5) {
            $k3 = 4;
        } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
            $k3 = 3;
        } elseif ($tahunDiff == 3) {
            $k3 = 2;
        } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
            $k3 = 1;
        } else {
            $k3 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k2 sesuai ketentuan
        $sisaCuti = $pengajuanCuti->sisa_cuti;
        if ($sisaCuti > 5) {
            $k2 = 4;
        } elseif ($sisaCuti == 4) {
            $k2 = 3;
        } elseif ($sisaCuti == 3) {
            $k2 = 2;
        } elseif ($sisaCuti >= 1 && $sisaCuti <= 2) {
            $k2 = 1;
        } else {
            $k2 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k4 sesuai ketentuan
        $lamaCuti = $pengajuanCuti->lama_cuti;
        if ($lamaCuti == 1) {
            $k4 = 4;
        } elseif ($lamaCuti == 2) {
            $k4 = 3;
        } elseif ($lamaCuti == 3) {
            $k4 = 2;
        } elseif ($lamaCuti > 3) {
            $k4 = 1;
        } else {
            $k4 = 0; // Jika tidak sesuai kondisi di atas
        }

        $data[] = [
            'nama_pegawai' => $pengajuanCuti->nama_pegawai,
            'k1' => $pengajuanCuti->nilai,
            'k2' => $k2,
            'k3' => $k3,
            'k4' => $k4
        ];

        $normalisasi = [];

foreach ($data as $item) {
    $Rij_satu = $item['k1'] / 4;
    $Rij_dua = $item['k2'] / 4;
    $Rij_tiga = $item['k3'] / 4;
// Pastikan k4 tidak bernilai 0 untuk menghindari pembagian dengan nol
$Rij_empat = ($item['k4'] != 0) ? 1 / $item['k4'] : 0;
    $normalisasi[] = [
        'nama_pegawai' => $item['nama_pegawai'],
        'Rij_satu' => number_format($Rij_satu, 2),
        'Rij_dua' => number_format($Rij_dua, 2),
        'Rij_tiga' => number_format($Rij_tiga, 2),
        'Rij_empat' => number_format($Rij_empat, 2)
    ];
}
    }
        //     $roc = new RankOrderCentroidController();
        //     $criteriaWeight = $roc->criteriaWeight();

        //     return view('admin.criteria.index', compact('criterias', 'criteriaWeight'));
        // }
        // dd($data);
        // dd($normalisasi);
        return view('normalisasi_pengajuan_cuti', ['data' => $normalisasi]);

    }
    //  non tahunan
    else if($jenis == "non-tahunan"){
        if(Session('user')['role'] === "Manager"){
        $pengajuanCutis = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
        ->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
        ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')->where('cuti_non.divisi_id', Session('user')['divisi'])
        ->get();
        }else{
            $pengajuanCutis = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
            ->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
            ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')
            ->get();
        }

    $data = [];
    foreach ($pengajuanCutis as $pengajuanCuti) {
        $tahunMasuk = (new \DateTime($pengajuanCuti->tgl_pegawai_masuk))->format('Y');
        $tahunSekarang = (new \DateTime())->format('Y');

        // Menghitung k3 sesuai ketentuan
        $tahunDiff = $tahunSekarang - $tahunMasuk;
        if ($tahunDiff > 5) {
            $k3 = 4;
        } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
            $k3 = 3;
        } elseif ($tahunDiff == 3) {
            $k3 = 2;
        } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
            $k3 = 1;
        } else {
            $k3 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k2 sesuai ketentuan
        $sisaCuti = $pengajuanCuti->sisa_cuti;
        if ($sisaCuti > 5) {
            $k2 = 4;
        } elseif ($sisaCuti == 4) {
            $k2 = 3;
        } elseif ($sisaCuti == 3) {
            $k2 = 2;
        } elseif ($sisaCuti >= 1 && $sisaCuti <= 2) {
            $k2 = 1;
        } else {
            $k2 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k4 sesuai ketentuan
        $lamaCuti = $pengajuanCuti->lama_cuti;
        if ($lamaCuti == 1) {
            $k4 = 4;
        } elseif ($lamaCuti == 2) {
            $k4 = 3;
        } elseif ($lamaCuti == 3) {
            $k4 = 2;
        } elseif ($lamaCuti > 3) {
            $k4 = 1;
        } else {
            $k4 = 0; // Jika tidak sesuai kondisi di atas
        }

        $data[] = [
            'nama_pegawai' => $pengajuanCuti->nama_pegawai,
            'k1' => $pengajuanCuti->nilai,
            'k2' => $k2,
            'k3' => $k3,
            'k4' => $k4
        ];

        $normalisasi = [];

        foreach ($data as $item) {
            // Mencari nilai maksimal untuk setiap kriteria
            $max_k1 = max(array_column($data, 'k1'));
            $max_k2 = max(array_column($data, 'k2'));
            $max_k3 = max(array_column($data, 'k3'));
            $min_k4 = min(array_column($data, 'k4'));

            // Menghitung nilai $Rij_satu sampai $Rij_empat
            $Rij_satu = $item['k1'] / $max_k1;
            $Rij_dua = $item['k2'] / $max_k2;
            $Rij_tiga = $item['k3'] / $max_k3;
            // Pastikan k4 tidak bernilai 0 untuk menghindari pembagian dengan nol
            // $Rij_empat = ($max_k4 != 0) ? $item['k4'] / $max_k4 : 0;
            $Rij_empat = ($item['k4'] != 0) ? $min_k4 / $item['k4'] : 0;

            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                'Rij_satu' => number_format($Rij_satu, 2),
                'Rij_dua' => number_format($Rij_dua, 2),
                'Rij_tiga' => number_format($Rij_tiga, 2),
                'Rij_empat' => number_format($Rij_empat, 2)
            ];
        }
    }
    // dd([$max_k1, $max_k2,$max_k3, $min_k4]);
        return view('normalisasi_pengajuan_cuti', ['data' => $normalisasi]);
    }
}

    public function hasil_akhir($jenis, Request $request)
    {

       if($jenis == 'tahunan'){

        $pengajuanCutis = Pengajuan_cuti::join('pegawai','pegawai.id','=','pengajuan_cuti.pegawai_id')
        ->join('urgensi_cuti', 'urgensi_cuti.id','=','pengajuan_cuti.urgensi_cuti_id')
        ->select('pengajuan_cuti.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')
        ->get();

    $data = [];
    foreach ($pengajuanCutis as $pengajuanCuti) {
        $tahunMasuk = (new \DateTime($pengajuanCuti->tgl_pegawai_masuk))->format('Y');
        $tahunSekarang = (new \DateTime())->format('Y');

        // Menghitung k3 sesuai ketentuan
        $tahunDiff = $tahunSekarang - $tahunMasuk;
        if ($tahunDiff > 5) {
            $k3 = 4;
        } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
            $k3 = 3;
        } elseif ($tahunDiff == 3) {
            $k3 = 2;
        } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
            $k3 = 1;
        } else {
            $k3 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k2 sesuai ketentuan
        $sisaCuti = $pengajuanCuti->sisa_cuti;
        if ($sisaCuti > 5) {
            $k2 = 4;
        } elseif ($sisaCuti == 4) {
            $k2 = 3;
        } elseif ($sisaCuti == 3) {
            $k2 = 2;
        } elseif ($sisaCuti >= 1 && $sisaCuti <= 2) {
            $k2 = 1;
        } else {
            $k2 = 0; // Jika tidak sesuai kondisi di atas
        }

        // Menghitung k4 sesuai ketentuan
        $lamaCuti = $pengajuanCuti->lama_cuti;
        if ($lamaCuti == 1) {
            $k4 = 4;
        } elseif ($lamaCuti == 2) {
            $k4 = 3;
        } elseif ($lamaCuti == 3) {
            $k4 = 2;
        } elseif ($lamaCuti > 3) {
            $k4 = 1;
        } else {
            $k4 = 0; // Jika tidak sesuai kondisi di atas
        }

        $data[] = [
            'id_pengajuan_cuti' => $pengajuanCuti->id_pengajuan_cuti,
            'nama_pegawai' => $pengajuanCuti->nama_pegawai,
            'tanggal_pengajuan' => $pengajuanCuti->tanggal_pengajuan,
            'lama_cuti' => $pengajuanCuti->lama_cuti,
            'keterangan' => $pengajuanCuti->nama,
            'status' => $pengajuanCuti->status,
            'verifikasi_oleh' => $pengajuanCuti->verifikasi_oleh,
            'k1' => $pengajuanCuti->nilai,
            'k2' => $k2,
            'k3' => $k3,
            'k4' => $k4
        ];

        $normalisasi = [];

        foreach ($data as $item) {
            // Mencari nilai maksimal untuk setiap kriteria
            $max_k1 = max(array_column($data, 'k1'));
            $max_k2 = max(array_column($data, 'k2'));
            $max_k3 = max(array_column($data, 'k3'));
            $min_k4 = min(array_column($data, 'k4'));

            // Menghitung nilai $Rij_satu sampai $Rij_empat
            $Rij_satu = $item['k1'] / $max_k1;
            $Rij_dua = $item['k2'] / $max_k2;
            $Rij_tiga = $item['k3'] / $max_k3;
            // Pastikan k4 tidak bernilai 0 untuk menghindari pembagian dengan nol
            // $Rij_empat = ($max_k4 != 0) ? $item['k4'] / $max_k4 : 0;
            $Rij_empat = ($item['k4'] != 0) ? $min_k4 / $item['k4'] : 0;

            $normalisasi[] = [
                'nama_pegawai' => $item['nama_pegawai'],
                'Rij_satu' => number_format($Rij_satu, 2),
                'Rij_dua' => number_format($Rij_dua, 2),
                'Rij_tiga' => number_format($Rij_tiga, 2),
                'Rij_empat' => number_format($Rij_empat, 2)
            ];
        }

// Menghitung nilai hasil akhir seperti sebelumnya
$hasil_akhir = [];

foreach ($normalisasi as $item2) {
    $nilai = (0.5 * ($item2['Rij_satu'] * 0.4 + $item2['Rij_dua'] * 0.3 + $item2['Rij_tiga'] * 0.2 + $item2['Rij_empat'] * 0.1)) +
             (0.5 * (pow($item2['Rij_satu'], 0.4) * pow($item2['Rij_dua'], 0.3) * pow($item2['Rij_tiga'], 0.2) * pow($item2['Rij_empat'], 0.1)));

    $hasil_akhir[] = [
        'id_pengajuan_cuti' => $item2['id_pengajuan_cuti'],
        'nama' => $item2['nama_pegawai'],
        'tanggal_pengajuan' => $item2['tanggal_pengajuan'],
        'lama_cuti' => $item2['lama_cuti'],
        'keterangan' => $item2['keterangan'],
        'status' => $item2['status'],
        'verifikasi_oleh' => $item2['verifikasi_oleh'],
        'skor_akhir' => number_format($nilai, 2)
    ];
}

// Mengurutkan nilai hasil akhir dari yang tertinggi ke yang terendah
usort($hasil_akhir, function($a, $b) {
    return $b['skor_akhir'] <=> $a['skor_akhir'];
});

    }

        $role['role'] = Session('user')['role'];
        // dd($hasil_akhir);
        return view('hasil_akhir_pengajuan_cuti', ['data' => $hasil_akhir, 'role' => $role]);
}else if($jenis == "non-tahunan"){
    if(Session("user")['role'] === "Manager"){
    $pengajuanCutis = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
    ->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
    ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai')->where('cuti_non.divisi_id', Session('user')['divisi']);
    }else{
        $pengajuanCutis = Pengajuan_cuti_non::join('pegawai','pegawai.id','=','cuti_non.pegawai_id')
        ->join('urgensi_cuti', 'urgensi_cuti.id','=','cuti_non.urgensi_cuti_id')
        ->select('cuti_non.*', 'pegawai.nama_pegawai', 'pegawai.created_at as tgl_pegawai_masuk','urgensi_cuti.nama', 'urgensi_cuti.lama_cuti', 'urgensi_cuti.nilai');
    }
    // ->get();


    if ($request->has('bulan')) {
        $pengajuanCutis->whereMonth('cuti_non.tanggal_pengajuan', $request->bulan);
    }

    $pengajuanCutis = $pengajuanCutis->get();
    if($pengajuanCutis->count() > 0){

$data = [];
foreach ($pengajuanCutis as $pengajuanCuti) {
    $tahunMasuk = (new \DateTime($pengajuanCuti->tgl_pegawai_masuk))->format('Y');
    $tahunSekarang = (new \DateTime())->format('Y');

    // Menghitung k3 sesuai ketentuan
    $tahunDiff = $tahunSekarang - $tahunMasuk;
    if ($tahunDiff > 5) {
        $k3 = 4;
    } elseif ($tahunDiff >= 4 && $tahunDiff <= 5) {
        $k3 = 3;
    } elseif ($tahunDiff == 3) {
        $k3 = 2;
    } elseif ($tahunDiff >= 1 && $tahunDiff <= 2) {
        $k3 = 1;
    } else {
        $k3 = 0; // Jika tidak sesuai kondisi di atas
    }

    // Menghitung k2 sesuai ketentuan
    $sisaCuti = $pengajuanCuti->sisa_cuti;
    if ($sisaCuti > 5) {
        $k2 = 4;
    } elseif ($sisaCuti == 4) {
        $k2 = 3;
    } elseif ($sisaCuti >= 2 && $sisaCuti <= 3) {
        $k2 = 2;
    } elseif ($sisaCuti >= 0 && $sisaCuti <= 1) {
        $k2 = 1;
    } else {
        $k2 = 0; // Jika tidak sesuai kondisi di atas
    }

    // Menghitung k4 sesuai ketentuan
    $lamaCuti = $pengajuanCuti->lama_cuti;
    if ($lamaCuti == 1) {
        $k4 = 4;
    } elseif ($lamaCuti == 2) {
        $k4 = 3;
    } elseif ($lamaCuti == 3) {
        $k4 = 2;
    } elseif ($lamaCuti > 3) {
        $k4 = 1;
    } else {
        $k4 = 0; // Jika tidak sesuai kondisi di atas
    }

    $data[] = [
        'id_cuti_non' => $pengajuanCuti->id_cuti_non,
        'nama_pegawai' => $pengajuanCuti->nama_pegawai,
        'tanggal_pengajuan' => $pengajuanCuti->tanggal_pengajuan,
        'lama_cuti' => $pengajuanCuti->lama_cuti,
        'keterangan' => $pengajuanCuti->nama,
        'status' => $pengajuanCuti->status,
        'verifikasi_oleh' => $pengajuanCuti->verifikasi_oleh,
        'k1' => $pengajuanCuti->nilai,
        'k2' => $k2,
        'k3' => $k3,
        'k4' => $k4
    ];

    $normalisasi = [];
foreach ($data as $item) {

    $max_k1 = max(array_column($data, 'k1'));
    $max_k2 = max(array_column($data, 'k2'));
    $max_k3 = max(array_column($data, 'k3'));
    $min_k4 = min(array_column($data, 'k4'));

    $Rij_satu = $item['k1'] / $max_k1;
    $Rij_dua = $item['k2'] / $max_k2;
    $Rij_tiga = $item['k3'] / $max_k3;
    // Pastikan k4 tidak bernilai 0 untuk menghindari pembagian dengan nol
    // $Rij_empat = ($max_k4 != 0) ? $item['k4'] / $max_k4 : 0;
    $Rij_empat = ($item['k4'] != 0) ? $min_k4 / $item['k4'] : 0;

$normalisasi[] = [
    'id_cuti_non' => $item['id_cuti_non'],
    'nama_pegawai' => $item['nama_pegawai'],
    'tanggal_pengajuan' => $item['tanggal_pengajuan'],
    'lama_cuti' => $item['lama_cuti'],
    'keterangan' => $item['keterangan'],
    'status' => $item['status'],
    'verifikasi_oleh' => $item['verifikasi_oleh'],
    'Rij_satu' => number_format($Rij_satu, 2),
    'Rij_dua' => number_format($Rij_dua, 2),
    'Rij_tiga' => number_format($Rij_tiga, 2),
    'Rij_empat' => number_format($Rij_empat, 2)
];
}

// Menghitung nilai hasil akhir seperti sebelumnya
$hasil_akhir = [];

foreach ($normalisasi as $item2) {
$nilai = (0.5 * ($item2['Rij_satu'] * 0.4 + $item2['Rij_dua'] * 0.3 + $item2['Rij_tiga'] * 0.2 + $item2['Rij_empat'] * 0.1)) +
         (0.5 * (pow($item2['Rij_satu'], 0.4) * pow($item2['Rij_dua'], 0.3) * pow($item2['Rij_tiga'], 0.2) * pow($item2['Rij_empat'], 0.1)));

$hasil_akhir[] = [
    'id_cuti_non' => $item2['id_cuti_non'],
    'nama' => $item2['nama_pegawai'],
    'tanggal_pengajuan' => $item2['tanggal_pengajuan'],
    'lama_cuti' => $item2['lama_cuti'],
    'keterangan' => $item2['keterangan'],
    'status' => $item2['status'],
    'verifikasi_oleh' => $item2['verifikasi_oleh'],
    'skor_akhir' => number_format($nilai, 2)
];
}

// Mengurutkan nilai hasil akhir dari yang tertinggi ke yang terendah
usort($hasil_akhir, function($a, $b) {
return $b['skor_akhir'] <=> $a['skor_akhir'];
});

}

    // dd($data);
    // dd($normalisasi);
    $role['role'] = Session('user')['role'];
    // dd($hasil_akhir);
    return view('hasil_akhir_pengajuan_cuti_non', ['data' => $hasil_akhir, 'role' => $role]);
}else{

    $hasil_akhir = [];

    $role['role'] = Session('user')['role'];

    return view('hasil_akhir_pengajuan_cuti_non', ['data' => $hasil_akhir, 'role' => $role]);

}
    }
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


}
