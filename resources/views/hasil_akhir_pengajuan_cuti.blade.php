@extends('template')

@section('title','- Manage Pengajuan Cuti')

@section('konten')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Manage Pengajuan Cuti</h4>
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

    </div>
    <!-- /row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Data Pengajuan Cuti</h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Skor Waspas</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Lama Cuti</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Verifikasi Oleh</th>
                                <th>Aksi</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            @foreach($data as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$item['nama']}}</td>
                                <td>{{$item['skor_akhir']}}</td>
                                <td>{{$item['tanggal_pengajuan']->translatedFormat('d M Y')}}</td>
                                <td>{{$item['lama_cuti']}} hari</td>
                                <td>{{$item['keterangan']}}</td>
                                <td>{{$item['status']}}</td>
                                <td>{{$item['verifikasi_oleh']}}</td>
                                <th>
                                    @if ($role =='Manager'))
                                    <a class="ml-auto mr-auto" href="/{{ Session('user')['role'] }}/manage-pengajuan-cuti/{{$item['id_pengajuan_cuti']}}/edit">
                                        <button class="btn btn-warning ml-auto mr-auto">Edit</button>
                                    </a>
                                    @endif
                                    @if ($item['status'] == 'verifikasi')
                                    <form class="ml-auto mr-auto mt-3" method="POST" action="/{{ Session('user')['role'] }}/manage-pengajuan-cuti/{{$item['id_pengajuan_cuti']}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                    </form>
                                    @endif

                                    @if ($item['status'] == 'disetujui')
                                    @if (in_array($role,['admin']))
                                    <form class="ml-auto mr-auto mt-3" method="POST" action="/{{ Session('user')['role'] }}/manage-pengajuan-cuti/{{$item['id_pengajuan_cuti']}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                    </form>
                                    @endif
                                    @endif

                                    @if ($item['status'] == 'disetujui')
                                    @if (in_array($role,['karyawan']))
                                    <a class="ml-auto mr-auto" target = "_blank" href="/{{ Session('user')['role'] }}/print-tahunan/{{ $item['id_pengajuan_cuti']}}">
                                        <button class="btn btn-success ml-auto mr-auto">Print</button>
                                    </a>
                                    @endif
                                    @endif

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
