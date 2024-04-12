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
			border-style: solid;
			border-width: 1px;
			border-color: rgb(255, 255, 255);
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
      <title> </title>
	  <link href="css/style1.css" rel="stylesheet">
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
					<font size="4"><b>PERMOHONAN CUTI TAHUNAN KARYAWAN</b></font><br>
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
			       <font size="2">Yth.<br><b>{{$pengajuan_cuti->nama_divisi}}</b><br>PT. Jasamarga Pandaan Tol<br>Di tempat</font>
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
				<td width="545">: <b>{{$pengajuan_cuti->nama_pegawai}}</b></td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td width="525">: <b>{{$pengajuan_cuti->nama_jabatan}}</b></td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td width="525">: <b>{{$pengajuan_cuti->nama_divisi}}</b></td>
			</tr>
                  <tr>
				<td>Tanggal Mulai Bekerja</td>
				<td width="100">: <b>{{$pengajuan_cuti->created_at->translatedFormat('d F Y')}}</b></td>
			</tr>
		</table>
		<table width="720">
			<tr>
		       <td>
			       <font size="2"><br>Dengan ini mengajukan permohonan Cuti Tahunan sebagai berikut :</font>
		       </td>
		    </tr>
		</table>
		<table>
			<tr >
				<td>Periode Cuti Tahunan</td>
				<td width="545">: <b>{{date('Y')}}</b></td>
			</tr>
			<tr>
				<td>Tanggal Pelaksanaan Cuti</td>
				<td width="525">: <b>{{$pengajuan_cuti->tanggal_pengajuan->translatedFormat('d F Y')}}</b></td>
			</tr>
			<tr>
				<td>Lama Cuti</td>
				<td width="525">: <b>{{$pengajuan_cuti->lama_cuti}} Hari</b></td>
			</tr>
                  <tr>
				<td>Keterangan</td>
				<td width="100">: <b>{{$pengajuan_cuti->keterangan}}</b></td>
			</tr>
                  <tr>
				<td>Alamat</td>
				<td width="100">: <b>{{$pengajuan_cuti->alamat}}</b></td>
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
		<table width="625" >
			<tr>
				<td width="430"><br><br></td>
				<td class="text" align="center"><p>Pandaan, <span id="tanggalwaktu"></span><br> Karyawan Yang Bersangkutan<br><br><img src="{{asset('ttd_karyawan/'.$pengajuan_cuti->ttd_karyawan)}}"alt="" style="height: 60px" ><br>{{$pengajuan_cuti->nama_pegawai}}</p></td>
			</tr>
	     </table>
		 <br>
		 <table width="720" border="1">
			<thead>
				<th width="550" align="left">
					<b>&ensp;&nbsp;KONFIRMASI HUMAN CAPITAL OFFICER</b>
				</th>
				<th>
					<b>Paraf</b>
				</th>
			</thead>
			<tr >
				<td>&emsp;Periode Cuti &emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;: <b>{{date('Y')}}</b>
					<br><br>&emsp;Jumlah Cuti Tahunan &ensp;&ensp;&ensp;&ensp;&nbsp;: 14 Hari &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; Cuti Yang Sudah Dijalani&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; : {{$cuti_terpakai}} Hari
					<br> &emsp;Jumlah Cuti Bersama &ensp;&ensp;&ensp;&ensp;&nbsp;: {{$cuti_bersama}} Hari &emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp; Cuti Yang Diajukan&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{$pengajuan_cuti->lama_cuti}} Hari
					<br> &emsp;Jumlah Cuti Periode &ensp;&ensp;&ensp;&nbsp;&emsp;: {{$jumlah_cuti}} Hari &emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp; Sisa Cuti &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;: {{$sisa_cuti}} Hari
				</td>
				<td class="text"><img src="{{asset('images/Rendy.png')}}"alt="" style="width: 100px" ></td>
			</tr>
		 </table> <br>
		 <table width="720" >
			<thead>
				<td align="left">
				<b>	Catatan : </b> {{$pengajuan_cuti->catatan}}
				</td>
				<td></td>
				<td></td>
			<tr>
				<td></td>
				<td width="320" class="text" align="center"><br>Menyetujui,<br> Pejabat Yang Berwenang<br><img src="{{asset('tanda_tangan/'.$pengajuan_cuti->image)}}"alt="" style="height: 60px" ><br>{{$pengajuan_cuti->verifikasi_oleh}}<br></td>
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

	</script>
	<script type="text/javascript">
		window.print();
	</script>
</html>
