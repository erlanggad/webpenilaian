@extends('template')

@section('title','- Form Konfigurasi Cuti')

@section('konten')
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
                <h3 class="box-title m-b-0">Form Konfigurasi Cuti</h3>
                <hr>
                <form class="form" action="/{{ Session('user')['role'] }}/konfigurasi-cuti" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Tahun</label>
                        <div class="col-10">
                            <input class="form-control" name="tahun" type="text" value="" id="example-text-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Cuti Bersama</label>
                        <div class="col-10">
                            <input class="form-control" name="cuti_bersama" type="text" value="" id="example-search-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Jumlah Cuti</label>
                        <div class="col-10">
                            <input class="form-control" name="jumlah_cuti" type="text" value="" id="example-search-input" required>
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
    @else
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Form Konfigurasi Cuti</h3>
                <hr>
                <form class="form" action="/{{ Session('user')['role'] }}/konfigurasi-cuti/{{Request::segment(3)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Tahun</label>
                        <div class="col-10">
                            <input class="form-control" name="tahun" type="text" value="{{$konfigurasi_cuti->tahun}}" id="example-text-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Jumlah Cuti Bersama</label>
                        <div class="col-10">
                            <input class="form-control" name="cuti_bersama" type="text" value="{{$konfigurasi_cuti->cuti_bersama}}" id="example-text-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Jumlah Cuti</label>
                        <div class="col-10">
                            <input class="form-control" name="jumlah_cuti" type="text" value="{{$konfigurasi_cuti->jumlah_cuti}}" id="example-search-input" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">

                            <button class="btn btn-primary btn-block" type="submit">Update</button>
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