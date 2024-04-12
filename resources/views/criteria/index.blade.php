{{-- @extends('templates.main')
@section('content') --}}
@extends('template')

@section('title','- Form Konfirmasi Pengajuan Cuti')

@section('konten')
<div id="main">
  <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>
  {{-- <div class="page-heading">
    <h3>Kriteria</h3>
  </div> --}}
  <div class="page-content">
    <section class="row">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <h4 class="card-title">Tabel Kriteria</h4>
          </div>
          <div class="card-content">
            {{-- <form action="{{ route('generateDB') }}" method="POST">
              @csrf --}}
              {{-- <a  class="btn btn-outline-success btn-sm m-2 ms-4" href="kriteria/create">
                Tambah Kriteria
              </a> --}}
              {{-- <button type="submit" class="btn btn-outline-primary btn-sm m-2">generete to database</button>
            </form> --}}
            @if(session()->has('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}
            </div>
            @endif
            <hr>
            <div class="table-responsive">
              <table class="table table-striped mb-0">
                <caption>
                  Tabel Alternatif C<sub>i</sub>
                </caption>

                <tr>
                  <th>Kriteria</th>
                  <th>Keterangan</th>
                  <th>Bobot</th>
                  <th>Benefit / Cost</th>
                  <th>Aksi</th>
                </tr>

                @foreach ($criterias as $key => $criteria)
                <tr>
                  <td>{{ $criteria->criteria }}</td>
                  <td>{{ $criteria->information }}</td>
                  <td>
                    {{ $criteria->weight }}
                  </td>
                  <td>{{ $criteria->type }}</td>
                  <td>
                    <form action="{{ route('kriteria.destroy',$criteria->id) }}" method="POST">
                      @csrf
                      @method("DELETE")
                      <a href="{{ route('kriteria.edit', ['kriterium' => $criteria->id]) }}" class='btn btn-info btn-sm'>Edit</a>

                      {{-- <button type="submit" class="btn btn-danger btn-sm">Hapus</button> --}}

                    </form>
                  </td>
                </tr>
                @endforeach

              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">Tambah Kriteria </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form action="{{ route('kriteria.store') }}" method="POST">
          @csrf

          <div class="modal-body">
            <label>Keterangan: </label>
            {{-- <div class="form-group">
              <input type="text" name="weight" class="form-control" hidden>
            </div> --}}
            <div class="form-group">
              <input type="text" name="information" placeholder="Information Name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="basicInput">Attribute</label>
              <select class="form-control form-select" name="type">
                <option value="benefit">Benefit</option>
                <option value="cost">Cost</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="submit" name="submit" class="btn btn-primary ml-1">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Simpan</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- @include('templates.partials.footer') --}}
</div>

@endsection
