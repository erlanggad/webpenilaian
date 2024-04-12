<!DOCTYPE html>
<html lang="en">

<head>
      <style type="text/css">
	  body{
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
      <title>Print Cuti Diluar Tahunan</title>
</head>
<body>
	<table width="720">
		<tr>
			<td>
				<img src="{{URL::asset('plugins/images/baruu.png')}}" width="110" height="55">
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
					<b><font size="4">PERMOHONAN CUTI DILUAR CUTI TAHUNAN KARYAWAN</font></b><br>
				</center>
				</td>
			</tr>
			<tr>
				<td colspan="2"><hr></td>
			</tr>

		</table>

		<br>
		<table width="720">
			<tr>
		       <td>
			       <font size="2">Yth.<br> <b>{{$cuti_non->nama_divisi }} </b><br>PT. Jasamarga Pandaan Tol<br>Di tempat</font>
		       </td>
		    </tr>
		</table>
		<br>
		<table width="720">
			<tr>
		       <td>
			       <font size="2">Yang bertanda tangan di bawah ini :</font>
		       </td>
		    </tr>
		</table>
		</table>
		<table>
			<tr >
				<td>Nama</td>
				<td width="545">: <b>{{$cuti_non->nama_pegawai}}</b></td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td width="525">: <b>{{$cuti_non->nama_jabatan}}</b></td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td width="525">: <b>{{$cuti_non->nama_divisi}}</b></td>
			</tr>
                  <tr>
				<td>Tanggal Mulai Bekerja</td>
				<td width="100">: <b>{{$cuti_non->created_at->translatedFormat('d F Y')}}</b></td>
			</tr>
		</table>
		<table width="720">
			<tr>
		       <td>
			       <font size="2">Dengan ini mengajukan permohonan Cuti Diluar Tahunan sebagai berikut :</font>
		       </td>
		    </tr>
		</table>
		</table>
		<table>
			<tr>
				<td>Tanggal Pelaksanaan Cuti</td>
				<td width="525">: <b>{{$cuti_non->tanggal_pengajuan->translatedFormat('d F Y')}}</b></td>
			</tr>
			<tr>
				<td>Lama Cuti</td>
				<td width="525">: <b>{{$cuti_non->lama_cuti}} Hari</b></td>
			</tr>
            <tr>
				<td>Keterangan</td>
				<td width="100">: <b>{{$cuti_non->keterangan}}</b></td>
			</tr>
			<tr>
				<td>Putusan Pejabat Berwenang</td>
				<td width="100">: <b>{{$cuti_non->status}}</b></td>
			</tr>
		</table>
		<table width="720">
			<tr>
		       <td>
			       <font size="2">Demikian surat permohonan cuti diajukan, atas perhatiannya diucapkan terima kasih.
</font>
		       </td>
		    </tr>
		</table>
		<br>
		<table width="720" border="1">
			<thead>
				<th>
					<B>PEJABAT BERWENANG</B>
				</th>
				<th>
					<B>PEMOHON </B>
				</th>
			</thead>
			<tr>
				<td width="350" class="text" align="center"><br><br><br><br><br><img src="{{asset('tanda_tangan/'.$cuti_non->image)}}"alt="" style="height: 60px" ><br>{{$cuti_non->verifikasi_oleh}}<br> <br><br></td>
				<td class="text" align="center">Pandaan, <span id="tanggalwaktu"></span> <br> Karyawan Yang Bersangkutan<br><br><img src="{{asset('uploadnon/'.$cuti_non->ttd_karyawan)}}"alt="" style="height: 60px" ><br>{{$cuti_non->nama_pegawai}}<br></td>
			</tr>
			<tr>
				<td> Catatan : {{$cuti_non->catatan}}</td>
			</tr>
	     </table>

	</center>
</body>
<script>
	var tw = new Date();
	if (tw.getTimezoneOffset() == 0) (a=tw.getTime() + ( 7 *60*60*1000))
	else (a=tw.getTime());
	tw.setTime(a);
	var tahun= tw.getFullYear ();
	var hari= tw.getDay ();
	var bulan= tw.getMonth ();
	var tanggal= tw.getDate ();
	var hariarray=new Array("Minggu,","Senin,","Selasa,","Rabu,","Kamis,","Jum'at,","Sabtu,");
	var bulanarray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
	document.getElementById("tanggalwaktu").innerHTML = " "+tanggal+" "+bulanarray[bulan]+" "+tahun;
	window.print();
	</script>
</html>
