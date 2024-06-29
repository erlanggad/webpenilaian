@extends('template')

@section('title', '- Manage Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Solusi Ideal Topsis</h4>
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
                            <img src="{{ asset('rumus/topsis_4.png') }}" alt="" style="width: 30%">


                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        @foreach ($kriteria as $k)
                                            <th>{{ $k->criteria }}</th>
                                        @endforeach
                                        {{-- <th>Status</th>
                                <th>Verifikasi Oleh</th>
                                <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($tipe as $item) --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Solusi Ideal Positif</td>
                                        @if ($solusi_ideal['solusi_ideal_positif'])
                                            @foreach ($solusi_ideal['solusi_ideal_positif'] as $item2)
                                                <td>{{ $item2 }}</td>
                                            @endforeach
                                        @else
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        @endif

                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Solusi Ideal Negatif</td>
                                        @if ($solusi_ideal['solusi_ideal_negatif'])

                                            @foreach ($solusi_ideal['solusi_ideal_negatif'] as $item2)
                                                <td>{{ $item2 }}</td>
                                            @endforeach
                                        @else
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        @endif
                                    </tr>
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.row -->
@endsection
