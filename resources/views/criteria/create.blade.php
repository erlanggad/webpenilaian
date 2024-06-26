@extends('template')

@section('title', '- Form Konfirmasi Pengajuan Cuti')

@section('konten')

    {{-- <div id="main"> --}}
    {{-- <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>
  <div class="page-heading">
    <h3>Kriteria Edit</h3>
  </div>
  <div class="page-content"> --}}
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

            </div>
            <!-- /.col-lg-12 -->
        </div>
        <section class="row">
            <div class="card col-sm-12">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('kriteria.store') }}" method="POST">
                                @csrf
                                {{-- @method('PATCH') --}}
                                <div class="form-group">
                                    <label for="basicInput">Keterangan</label>
                                    <input type="text" class="form-control mb-3" name="information" value="">
                                </div>
                                <div class="form-group">
                                    <label for="basicInput">Bobot</label>
                                    <input type="number" class="form-control mb-3" name="weight" step="0.01"
                                        value="" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="basicInput">Benefit / Cost</label>
                                    <select class="form-control form-select" name="type">
                                        <option value="benefit">Benefit</option>
                                        <option value="cost">Cost</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-info btn-sm">
                                    <a class="btn btn-warning btn-sm" href="{{ route('kriteria.index') }}"> Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- </div> --}}
    {{-- </div> --}}

@endsection
