@extends('template')

@section('title', '- Manage Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Konversi Alternatif (Cuti Non Tahunan)</h4>
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
                    <h3 class="box-title m-b-0" style="font-size:17px">Keterangan</h3>
                    <div class="table-responsive">
                        <ul style="">
                            @foreach ($data['kriteria'] as $criterias)
                                <li>{{ $criterias->criteria }} = {{ $criterias->information }} ({{ $criterias->weight }})
                                </li>
                            @endforeach


                        </ul>
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>C1</th>
                                    <th>C2</th>
                                    <th>C3</th>
                                    <th>C4</th>
                                    <th>C5</th>
                                    <th>C6</th>
                                    <th>C7</th>
                                    <th>C8</th>

                                    {{-- <th>Status</th>
                                <th>Verifikasi Oleh</th>
                                <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                ?>
                                @foreach ($data['penilaian'] as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item['nama_pegawai'] }}</td>
                                        <td>{{ $item['c1'] }}</td>
                                        <td>{{ $item['c2'] }}</td>
                                        <td>{{ $item['c3'] }}</td>
                                        <td>{{ $item['c4'] }}</td>
                                        <td>{{ $item['c5'] }}</td>
                                        <td>{{ $item['c6'] }}</td>
                                        <td>{{ $item['c7'] }}</td>
                                        <td>{{ $item['c8'] }}</td>


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
