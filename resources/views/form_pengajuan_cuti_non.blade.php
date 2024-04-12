@extends('template')

@section('title','- Form Pengajuan Cuti')

@section('konten')
@php
    use App\Models\Divisi;
@endphp
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Form</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Request::segment(3) == 'create')
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Form Pengajuan Cuti</h3>
                <hr>
                <form class="form" action="/karyawan/store-pengajuan-non" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Tanggal Awal </label>
                        <div class="col-10">
                            <input class="form-control" name="tanggal_pengajuan" type="date" value="" id="example-email-input" required>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Tanggal Akhir </label>
                        <div class="col-10">
                            <input class="form-control" name="tanggal_akhir" type="date" value="" id="example-email-input" required>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Tanggal Awal </label>
                        <div class="col-10">
                            <input class="form-control" name="tanggal_pengajuan" type="date" value="" id="tanggal_awal" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Tanggal Akhir </label>
                        <div class="col-10">
                            <input class="form-control" name="tanggal_akhir" type="date" value="" id="tanggal_akhir" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Lama Cuti</label>
                        <div class="col-10">
                            <input class="form-control" name="lama_cuti" type="number" min="1" value="0" id="lama_cuti" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                           <select name="urgensi_cuti_id" class="form-control" id="urgensi_cuti_id" required>
                            <option value="" disabled selected>Pilih Keterangan</option>
                            @foreach ($urgensi_cuti as $list_urgensi)
                                <option value="{{ $list_urgensi->id }}">{{ $list_urgensi->nama }}</option>
                            @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="image" class="col-2 col-form-label">Lampiran</label>
                        <div class="col-10">
                            <input class="form-control" name="image" type="file" id="example-email-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Ditujukan kepada</label>
                        <div class="col-10">
                            @php

                                $divisi = Divisi::where('id', Session('user')['divisi'] )->first();
                            @endphp
                            <input class="form-control" name="divisi_id" type="text" min="1" value="{{ $divisi['id'] }}" id="divisi_id" required hidden>
                            <input class="form-control" name="" type="text" min="1" value="{{ $divisi['nama'] }}" id="" required readonly>


                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-2 col-form-label">Tanda Tangan</label>
                        <div class="col-10">
                            <input class="form-control" name="ttd_karyawan" type="file" id="example-email-input" required accept="image/*">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">

                            <button class="btn btn-primary btn-block" type="submit">Buat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->

    @endif

</div>
<script>
    document.getElementById('urgensi_cuti_id').addEventListener('change', function() {
        var selectedId = this.value;
        console.log(selectedId)
        if(selectedId) {
            fetch('/urgensi_cuti_detail/' + selectedId)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // console.log(data.data)
                        document.getElementById('lama_cuti').value = data.data.lama_cuti;
                        updateTanggalAkhir();

                    } else {
                        console.error('Data tidak ditemukan');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });

     // Hitung tanggal akhir berdasarkan tanggal awal dan lama cuti
     function updateTanggalAkhir() {
        var tanggalAwal = document.getElementById('tanggal_awal').value;
        var lamaCuti = parseInt(document.getElementById('lama_cuti').value);
        if (tanggalAwal && lamaCuti) {
            var dateAwal = new Date(tanggalAwal);
            dateAwal.setDate(dateAwal.getDate() + lamaCuti);
            var tanggalAkhir = dateAwal.toISOString().split('T')[0];
            document.getElementById('tanggal_akhir').value = tanggalAkhir;
        }
        console.log("tanggalawal", tanggalAwal);
        console.log("lamaCuti", lamaCuti);
    }

    // Panggil fungsi updateTanggalAkhir saat tanggal_awal berubah
    document.getElementById('tanggal_awal').addEventListener('change', updateTanggalAkhir);

</script>

@endsection
