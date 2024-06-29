@extends('template')

@section('title', '- Hasil Normalisasi Moora')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Hasil Normalisasi Moora</h4>
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
        </div>
        <!-- /row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h2 class="box-title m-b-0" style="font-size:17px">Rumus</h2>
                    <div class="table-responsive">
                        <img src="{{ asset('rumus/Kriteriabenefit.png') }}" alt="" style="width: 40%">

                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    @foreach ($kriteria as $k)
                                        <th>{{ $k->criteria }}</th>
                                    @endforeach
                                    {{-- <th>C1</th>
                                    <th>C2</th>
                                    <th>C3</th>
                                    <th>C4</th>
                                    <th>C5</th>
                                    <th>C6</th>
                                    <th>C7</th>
                                    <th>C8</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($normalisasi as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item['nama_pegawai'] }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>{{ $item[$k->criteria] }}
                                            </td>
                                        @endforeach
                                        {{-- <td>{{ $item['C1'] }}</td>
                                        <td>{{ $item['C2'] }}</td>
                                        <td>{{ $item['C3'] }}</td>
                                        <td>{{ $item['C4'] }}</td>
                                        <td>{{ $item['C5'] }}</td>
                                        <td>{{ $item['C6'] }}</td>
                                        <td>{{ $item['C7'] }}</td>
                                        <td>{{ $item['C8'] }}</td> --}}
                                    </tr>
                                    @php $no++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
