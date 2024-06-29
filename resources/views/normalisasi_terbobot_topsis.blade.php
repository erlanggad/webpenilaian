@extends('template')

@section('title', '- Manage Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Hasil Normalisasi Terbobot Topsis</h4>
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
                    <h2 class="box-title m-b-0" style="font-size:17px">Rumus</h3>
                        <div class="table-responsive">
                            <img src="{{ asset('rumus/topsis_3.png') }}" alt="" style="width: 30%">


                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        @foreach ($kriteria as $k)
                                            <th>{{ $k->criteria }}</th>
                                        @endforeach
                                        {{-- <th>Status</th>
                                <th>Verifikasi Oleh</th>
                                <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($atribut_optimal as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item['nama_pegawai'] }}</td>
                                            @foreach ($kriteria as $k)
                                                <td>{{ $item[$k->criteria] }}
                                                </td>
                                            @endforeach


                                        </tr>
                                        <?php $no++; ?>
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
