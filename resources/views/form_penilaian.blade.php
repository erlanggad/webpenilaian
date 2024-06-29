@extends('template')

@section('title', '- Form Penilaian Kinerja')

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
                        <h3 class="box-title m-b-0">Form Penilaian Kinerja</h3>
                        <hr>

                        <!-- Display error message if exists -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session('user')['role'] == 'Kepala Bagian')
                            <form class="form" action="/kepala-bagian/form-penilaian/store" method="post"
                                enctype="multipart/form-data">
                            @elseif (Session('user')['role'] == 'Kepala Sub Bagian')
                                <form class="form" action="/kepala-sub-bagian/form-penilaian/store" method="post"
                                    enctype="multipart/form-data">
                        @endif

                        @csrf

                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Pilih Pegawai</label>
                            <div class="col-10">
                                <select name="pegawai_id" class="form-control" id="pegawai_id" required>
                                    <option value="" disabled selected>Pilih Pegawai</option>
                                    @foreach ($pegawai as $list)
                                        <option value="{{ $list->id }}">{{ $list->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="periode" class="col-2 col-form-label">Pilih Periode</label>
                            <div class="col-10">
                                <select name="periode" class="form-control" id="periode" required>
                                    <option value="" disabled selected>Pilih Periode</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>

                        @foreach ($criteria as $criterias)
                            <div class="form-group row">
                                <label for="example-email-input" class="col-2 col-form-label">Nilai
                                    {{ $criterias->information }} ({{ $criterias->criteria }})</label>
                                <div class="col-10">
                                    <input class="form-control" name="{{ $criterias->id }}" type="number" min="1"
                                        max="100" value="0" id="{{ $criterias->criteria }}" required>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit">Kirim</button>
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
                        <h3 class="box-title m-b-0">Form Penilaian Kinerja</h3>
                        <hr>
                        @if (Session('user')['role'] == 'Kepala Bagian')
                            <form class="form" action="/kepala-bagian/form-penilaian/{{ Request::segment(3) }}"
                                method="post" enctype="multipart/form-data">
                            @elseif (Session('user')['role'] == 'Kepala Sub Bagian')
                                <form class="form" action="/kepala-sub-bagian/form-penilaian/{{ Request::segment(3) }}"
                                    method="post" enctype="multipart/form-data">
                        @endif
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="pegawai_id" class="col-2 col-form-label">Pilih Pegawai</label>
                            <div class="col-10">
                                <select name="pegawai_id" class="form-control" id="pegawai_id" required>
                                    <option value="" disabled selected>Pilih Pegawai</option>
                                    @foreach ($pegawai as $list)
                                        <option value="{{ $list->id }}"
                                            {{ $list->id == $penilaian->pegawai_id ? 'selected' : '' }}>
                                            {{ $list->nama_pegawai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="periode" class="col-2 col-form-label">Pilih Periode</label>
                            <div class="col-10">
                                <select name="periode" class="form-control" id="periode" required>
                                    <option value="" disabled>Pilih Periode</option>
                                    @for ($year = 2019; $year <= 2024; $year++)
                                        <option value="{{ $year }}"
                                            {{ $year == $penilaian->periode ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        @foreach ($criteria as $criterias)
                            <div class="form-group row">
                                <label for="criteria_{{ $criterias->id }}" class="col-2 col-form-label">Nilai
                                    {{ $criterias->information }} ({{ $criterias->criteria }})</label>
                                <div class="col-10">
                                    @php
                                        $nilai = $penilaian->firstWhere('criteria_id', $criterias->id)->nilai ?? 0;
                                    @endphp
                                    <input class="form-control" name="criteria[{{ $criterias->id }}]" type="number"
                                        min="1" max="100" value="{{ $nilai }}"
                                        id="criteria_{{ $criterias->id }}" required>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit">Kirim</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
