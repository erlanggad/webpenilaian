@extends('template')

@section('title', '- Konversi Alternatif')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Konversi Alternatif</h4>
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
                    <h3 class="box-title m-b-0" style="font-size:17px">Keterangan</h3>
                    <div class="table-responsive">
                        <ul>
                            @foreach ($kriteria as $criterias)
                                <li>{{ $criterias->criteria }} = {{ $criterias->information }} ({{ $criterias->weight }})
                                </li>
                            @endforeach
                        </ul>
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    @foreach ($kriteria as $criterias)
                                        <th>{{ $criterias->criteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($penilaian->groupBy(['pegawai_id', 'periode']) as $pegawaiPeriode => $penilaianGroup)
                                    @foreach ($penilaianGroup as $periode => $penilaians)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $penilaians->first()->pegawai->nama_pegawai }}</td>
                                            @foreach ($kriteria as $criteria)
                                                <td>
                                                    @php
                                                        $nilai = $penilaians->firstWhere('criteria_id', $criteria->id);
                                                    @endphp
                                                    {{ $nilai ? $nilai->nilai : '-' }}
                                                </td>
                                            @endforeach
                                            {{-- <td>{{ $periode }}</td>
                                            <td>
                                                @if (in_array($role, ['Kepala Sub Bagian']))
                                                    <a class="ml-auto mr-auto"
                                                        href="/kepala-sub-bagian/form-penilaian/{{ $penilaians->first()->id }}/edit">
                                                        <button class="btn btn-warning ml-auto mr-auto">Edit</button>
                                                    </a>
                                                    <form class="ml-auto mr-auto mt-3" method="POST"
                                                        action="/kepala-sub-bagian/form-penilaian/{{ $penilaians->first()->id }}">
                                                        {{ csrf_field() }}
                                                        @method('DELETE')
                                                        <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                                    </form>
                                                @elseif (in_array($role, ['Kepala Bagian']))
                                                    <a class="ml-auto mr-auto"
                                                        href="/kepala-bagian/form-penilaian/{{ $penilaians->first()->id }}/edit">
                                                        <button class="btn btn-warning ml-auto mr-auto">Edit</button>
                                                    </a>
                                                    <form class="ml-auto mr-auto mt-3" method="POST"
                                                        action="/kepala-bagian/form-penilaian/{{ $penilaians->first()->id }}">
                                                        {{ csrf_field() }}
                                                        @method('DELETE')
                                                        <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                                    </form>
                                                @elseif (in_array($role, ['karyawan']))
                                                    <a class="ml-auto mr-auto" target="_blank"
                                                        href="/karyawan/print/?id={{ $penilaians->first()->id }}&tahun={{ $periode }}">
                                                        <button class="btn btn-success ml-auto mr-auto">Print</button>
                                                    </a>
                                                @endif
                                            </td> --}}
                                        </tr>
                                        <?php $no++; ?>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
