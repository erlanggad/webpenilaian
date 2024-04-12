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
                <form class="form" action="/{{ Session('user')['role'] }}/store-pengajuan" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Tanggal Pengajuan</label>
                        <div class="col-10">
                            <input class="form-control" name="tanggal_pengajuan" type="date" value="" id="example-email-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Lama Cuti (hari)</label>
                        <div class="col-10">
                            <input class="form-control" name="lama_cuti" type="number" min="1" value="" id="example-email-input" required placeholder="Lama Cuti (hari)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <input class="form-control" name="keterangan" type="text" value="" id="example-email-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Alamat</label>
                        <div class="col-10">
                            <input class="form-control" name="alamat" type="text" value="" id="example-email-input" required>
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
@endsection
