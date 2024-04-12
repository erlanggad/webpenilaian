@extends('template')

@section('title','- Konfigurasi Cuti')

@section('konten')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Konfigurasi Cuti</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::has('failed'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('failed') }}
            </div>
            @endif
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-md-12">
            <a href="/{{ Session('user')['role'] }}/konfigurasi-cuti/create">
                <button class="btn btn-primary btn-block">Tambah</button>
            </a>
        </div>
    </div>
    <!-- /row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Data Konfigurasi Cuti</h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Jumlah Cuti Bersama</th>
                                <th>Jumlah Cuti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            @foreach($konfigurasi_cuti as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$item->tahun}}</td>
                                <td>{{$item->cuti_bersama}}</td>
                                <td>{{$item->jumlah_cuti}}</td>
                                <th>
                                    <a class="ml-auto mr-auto" href="/{{ Session('user')['role'] }}/konfigurasi-cuti/{{$item->id_konfig_cuti}}/edit">
                                        <button class="btn btn-warning ml-auto mr-auto">Edit</button>
                                    </a>
                                    <form class="ml-auto mr-auto mt-3" method="POST" action="/{{ Session('user')['role'] }}/konfigurasi-cuti/{{$item->id_konfig_cuti}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                    </form>
                                </th>
                            </tr>
                            <?php $no++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.row -->
@endsection