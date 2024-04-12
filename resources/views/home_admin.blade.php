@extends('template')

@section('title','- Home')

@section('konten')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Dashboard</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">

            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Jumlah Karyawan</h3>
                <ul class="list-inline two-part">
                    <li>
                    </li>
                    <li class="text-right"><span class="counter text-info">{{$jumlah_karyawan}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Jumlah Manager</h3>
                <ul class="list-inline two-part">
                    <li>
                    </li>
                    <li class="text-right"><span class="counter text-info">{{$jumlah_staf_hr}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Verifikasi Cuti {{date('Y')}}</h3>
                <ul class="list-inline two-part">
                    <li>
                    </li>
                    {{-- <li class="text-right"> <span class="counter text-info">{{$pengajuan_cuti_verifikasi}}</span></li> --}}
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Total Cuti {{date('Y')}}</h3>
                <ul class="list-inline two-part">
                    <li>
                    </li>
                    {{-- <li class="text-right"> <span class="text-info counter">{{$total_pengajuan_cuti}}</span></li> --}}
                </ul>
            </div>
        </div>
    </div>
    <!--/.row -->

</div>
<!-- /.container-fluid -->
@endsection
