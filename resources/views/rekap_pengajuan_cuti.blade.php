@extends('template')

@section('title','- Rekap Pengajuan Cuti')

@section('konten')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Rekap Cuti Karyawan</h4>
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
        <div class="col-md-12">
            <!-- <a href="/rekap-pengajuan-cuti/create">
                <button class="btn btn-primary btn-block">Tambah</button>
            </a> -->
        </div>
    </div>
    <!-- /row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Data Rekap Pengajuan Cuti</h3>
                <div class="col-md-4"></div>
                <div class="col-md-3 mb-4">
                    <label for="tahun">Filter Tahun:</label>
                    <select class="form-control" id="tahun" name="tahun">
                        <option id="semua-tahun-option" value="" {{ request('tahun') == '' ? 'selected' : '' }}>Semua Tahun</option>
                        @foreach($tahun_list as $tahun_item)
                            <option value="{{ $tahun_item }}" {{ request('tahun') == $tahun_item ? 'selected' : '' }}>{{ $tahun_item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Tahun</th>
                                <th>Jumlah Cuti</th>
                                <th>Cuti Terpakai</th>
                                <th>Sisa Cuti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            @foreach($sisa_cuti as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$item->nama_pegawai}}</td>
                                <td>{{$item->tahun}}</td>
                                <td>{{$item->jumlah_cuti}}</td>
                                <td>{{$item->cuti_terpakai}}</td>
                                <td>{{$item->sisa_cuti}}</td>
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
<script>
    document.getElementById('tahun').addEventListener('change', function() {
        var tahun = this.value;
        var url = "{{ Session('user')['role'] === 'Manager' ? route('rekap_pengajuan_cuti.index') : route('rekap_pengajuan_cuti.indexAdmin') }}";
        if (tahun) {
            url += "?tahun=" + tahun;
        }
        window.location.href = url;
    });

    // Function to update the "Semua Tahun" option based on the selected year
    function updateSemuaTahunOption(selectedYear) {
        var semuaTahunOption = document.getElementById('semua-tahun-option');
        if (!selectedYear) {
            semuaTahunOption.selected = true;
        }
    }

    // Initial call to update the "Semua Tahun" option based on the selected year
    var selectedYear = new URLSearchParams(window.location.search).get('tahun');
    updateSemuaTahunOption(selectedYear);
</script>


<!-- /.row -->
@endsection
