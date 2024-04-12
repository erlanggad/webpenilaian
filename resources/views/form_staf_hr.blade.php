@extends('template')

@section('title','- Form Pejabat Struktural')

@section('konten')
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
                <h3 class="box-title m-b-0">Form Pejabat Struktural</h3>
                <hr>
                <form class="form" action="/{{Session('user')['role']}}/manage-pejabat-struktural" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Nama Pejabat Struktural</label>
                        <div class="col-10">
                            <input class="form-control" name="nama_pejabat_struktural" type="text" value="" id="example-text-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
                        <div class="col-10">
                           <select name="jabatan" class="form-control" id="" required>
                            <option>Direktur Utama</option>
                            <option>Direktur Keuangan & Umum</option>
                            <option>General Manager Finance & HCGA</option>
                            <option>General Manager Operation & Maintenance</option>
                            <option>Finance Manager</option>
                            <option>Human Capital General Affair & Manager</option>
                            <option>Operation Manager</option>
                            <option>Maintenance Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Email</label>
                        <div class="col-10">
                            <input class="form-control" name="email" type="email" value="" id="example-search-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Password</label>
                        <div class="col-10">
                            <input class="form-control" name="password" type="password" value="" id="example-email-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-2 col-form-label">Tanda Tangan</label>
                        <div class="col-10">
                            <input class="form-control" name="image" type="file" id="example-email-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">

                            <button class="btn btn-primary btn-block" type="submit">Buat</button>
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
                <h3 class="box-title m-b-0">Form Pejabat Struktural</h3>
                <hr>
                <form class="form" action="/{{Session('user')['role']}}/manage-pejabat-struktural/{{Request::segment(3)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="example-text-input" class="col-2 col-form-label">Nama Pejabat Struktural</label>
                        <div class="col-10">
                            <input class="form-control" name="nama_pejabat_struktural" type="text" value="{{$staf_hr->nama_pejabat_struktural}}" id="example-text-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
                        <div class="col-10">
                           <select name="jabatan" class="form-control" value="{{$staf_hr->jabatan}}" id="" required>
                                <option>Direktur Utama</option>
                                <option>Direktur Keuangan & Umum</option>
                                <option>General Manager Finance & HCGA</option>
                                <option>General Manager Operation & Maintenance</option>
                                <option>Finance Manager</option>
                                <option>Human Capital General Affair & Manager</option>
                                <option>Operation Manager</option>
                                <option>Maintenance Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Email</label>
                        <div class="col-10">
                            <input class="form-control" name="email" type="email" value="{{$staf_hr->email}}" id="example-search-input" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-2 col-form-label">Tanda Tangan</label>
                        <div class="col-10">
                            <input class="form-control" name="image" value="{{$staf_hr->image}}" type="file" id="example-email-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">

                            <button class="btn btn-primary btn-block" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
    @endif

</div>
@endsection