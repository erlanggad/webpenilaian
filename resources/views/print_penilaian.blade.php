<!DOCTYPE html>
<html lang="en">

<head>
    <style type="text/css">
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            font: "Tahoma";
        }

        .table {
            border-style: double;
            border-width: 3px;
            border-color: white;
        }

        table tr .text2 {
            text-align: right;
            font-size: 13px;
        }

        table tr .text3 {
            text-align: right;
            font-size: 13px;
        }

        table tr .text {
            text-align: center;
            font-size: 13px;
        }

        table tr td {
            font-size: 13px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Penilaian Saya</title>
</head>

<body>
    <table width="720">
        <tr>
            <td>
                {{-- <img src="{{ URL::asset('header_print.jpeg') }}" width="110" height="55"> --}}
            </td>
        </tr>
    </table>
    <center>
        <table>
            <tr>

            </tr>
            <tr>
                <td>
                    <center>
                        <img src="{{ URL::asset('header_print.jpeg') }}" width="100%">

                        {{-- <b>
                            <font size="4">PERMOHONAN CUTI DILUAR CUTI TAHUNAN KARYAWAN</font>
                        </b> --}}
                        <br>
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>

        </table>

        {{-- <table width="720">
            <tr>
                <td>
                    <font size="2">Yth.<br> <b>{{ $penilaian->nama_divisi }} </b><br>PT. Jasamarga Pandaan
                        Tol<br>Di tempat</font>
                </td>
            </tr>
        </table>
        <br> --}}

        </table>
        <table width='720' border="0">
            <tr>
                <td style="font-size: 16px">Nama</td>
                <td style="font-size: 16px" width="545">: <b>{{ $penilaian->nama_pegawai }}</b></td>
            </tr>
            <tr>
                <td style="font-size: 16px">NIK</td>
                <td style="font-size: 16px" width="525">: <b>{{ $penilaian->nik }}</b></td>
            </tr>
            <tr>
                <td style="font-size: 16px">Jabatan</td>
                <td style="font-size: 16px" width="525">: <b>{{ $penilaian->nama_jabatan }}</b></td>
            </tr>
            <tr>
                <td style="font-size: 16px">Divisi</td>
                <td style="font-size: 16px" width="525">: <b>{{ $penilaian->nama_divisi }}</b></td>
            </tr>

        </table>
        </table>
        <br>
        {{-- <table>
            <tr>
                <td>Tanggal Pelaksanaan Cuti</td>
                <td width="525">: <b>{{ $penilaian->tanggal_pengajuan->translatedFormat('d F Y') }}</b></td>
            </tr>
            <tr>
                <td>Lama Cuti</td>
                <td width="525">: <b>{{ $penilaian->lama_cuti }} Hari</b></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td width="100">: <b>{{ $penilaian->keterangan }}</b></td>
            </tr>
            <tr>
                <td>Putusan Pejabat Berwenang</td>
                <td width="100">: <b>{{ $penilaian->status }}</b></td>
            </tr>
        </table> --}}
        <table width="720" border="1">
            <thead>
                <th>
                    UNSUR YANG DINILAI
                </th>
                <th>
                    NILAI
                </th>
            </thead>
            <tbody>
                <?php $no = 1; ?>

                @foreach ($criteria as $criterias)
                    <tr>
                        <td style="font-size: 16px;padding:2px 20px">{{ $no . '. ' . $criterias->information }}</td>
                        <td style="text-align: center">{{ $penilaian->{strtolower($criterias->criteria)} ?? 0 }}</td>
                    </tr>
                    <?php $no++; ?>
                @endforeach
                <tr>
                    <td style="font-size: 16px;padding:2px 20px">Jumlah</td>
                    <td style="text-align: center">{{ $totalNilai }}</td>
                </tr>
                <tr>
                    <td style="font-size: 16px;padding:2px 20px">Nilai Rata-Rata</td>
                    <td style="text-align: center">{{ $rataNilai }}</td>
                </tr>
                <tr>
                    <td style="font-size: 16px;padding:2px 20px">Skor Topsis</td>
                    <td style="text-align: center">{{ $userTopsis['skor_akhir'] }}</td>
                </tr>
                <tr>
                    <td style="font-size: 16px;padding:2px 20px">Skor Moora</td>
                    <td style="text-align: center">{{ $userMoora['skor_akhir'] }}</td>
                </tr>
                <tr>
                    <td style="font-size: 16px;padding:2px 20px">Skor Waspas</td>
                    <td style="text-align: center">{{ $userWaspas['skor_akhir'] }}</td>
                </tr>

            </tbody>
        </table>
        <table width="720">
            <tr>
                <td></td>
                <td style="text-align: right; font-size:16px">
                    <h4>Dibuat Tanggal : {{ $penilaian->created_at->translatedFormat('d F Y') }}
                    </h4>
                </td>

            </tr>

        </table>
        <table width="720">
            <thead>
                <th>
                    <B>KARYAWAN YANG DINILAI</B>
                </th>
                <th>
                    <B>ATASAN LANGSUNG </B>
                </th>
            </thead>
            <tr>

                <td class="text" align="center"><br><br><img
                        src="{{ asset('uploadnon/' . $penilaian->ttd_karyawan) }}"alt="" style="height: 60px"><br>
                    <h4 style="font-size: 15px; text-transform :capitalize">{{ $penilaian->nama_pegawai }}
                        <br>
                        ( {{ $penilaian->nik }} )
                    </h4>
                </td>
                <td class="text" align="center"><br><br><img
                        src="{{ asset('uploadnon/' . $penilaian->ttd_karyawan) }}"alt="" style="height: 60px"><br>
                    <h4 style="font-size: 15px; text-transform :capitalize">{{ $atasan->nama_pegawai }}
                        <br>
                        ( {{ $atasan->nik }} )
                    </h4>
                </td>
            </tr>

        </table>
        <table width="720" border="0">
            <tr>
                <td></td>
                <td style="width: 45%; font-size:16px">
                    <center>
                        MENGETAHUI/MENYETUJUI
                        PERUSAHAAN DAERAH AIR MINUM
                        KABUPATEN PROBOLINGGO
                        DIREKTUR
                    </center>
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="width: 45%; font-size:18px">
                    <br>
                    <br>
                    <br>

                    <center>
                        <h4 style="font-size: 15px; text-transform :capitalize">
                            {{ $direktur->nama_pegawai }}
                        </h4>
                    </center>
                </td>
                <td></td>
            </tr>
        </table>

    </center>
</body>
<script>
    var tw = new Date();
    if (tw.getTimezoneOffset() == 0)(a = tw.getTime() + (7 * 60 * 60 * 1000))
    else(a = tw.getTime());
    tw.setTime(a);
    var tahun = tw.getFullYear();
    var hari = tw.getDay();
    var bulan = tw.getMonth();
    var tanggal = tw.getDate();
    var hariarray = new Array("Minggu,", "Senin,", "Selasa,", "Rabu,", "Kamis,", "Jum'at,", "Sabtu,");
    var bulanarray = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
        "Oktober", "Nopember", "Desember");
    document.getElementById("tanggalwaktu").innerHTML = " " + tanggal + " " + bulanarray[bulan] + " " + tahun;
    //window.print();
</script>

</html>
