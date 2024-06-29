@extends('template')

@section('title', '- Manage Penilaian')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Penilaian</h4>
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
                @if ($role == 'Kepala Bagian')
                    <a href="/kepala-bagian/form-penilaian/create">
                        <button class="btn btn-primary btn-block" style="background-color: #1E90FF">Tambah</button>
                    </a>
                @elseif ($role == 'Kepala Sub Bagian')
                    <a href="/kepala-sub-bagian/form-penilaian/create">
                        <button class="btn btn-primary btn-block" style="background-color: #1E90FF">Tambah</button>
                    </a>
                @endif
            </div>
        </div>
        <!-- /row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Data Penilaian Kinerja Karyawan</h3>
                    <div class="col-md-4"></div>
                    {{-- <div class="col-md-3 mb-4">
                        <label for="bulan">Filter Bulans:</label>
                        <select class="form-control" id="bulan" name="bulan">
                            <option id="semua-bulan-option" value="" {{ request('bulan') == '' ? 'selected' : '' }}>
                                Semua Bulan</option>
                            <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>

                        </select>
                    </div> --}}
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    @foreach ($kriteria as $list)
                                        <th>{{ $list->criteria }}</th>
                                    @endforeach
                                    <th>Periode</th>
                                    <th>Aksi</th>
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
                                            <td>{{ $periode }}</td>
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
                                            </td>
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
    <!-- Tambahkan bagian JavaScript di bawah dropdown -->
    <script>
        // document.getElementById('bulan').addEventListener('change', function() {
        //     var bulan = this.value;
        //     var url =


        //     if (bulan) {
        //         url += "?bulan=" + bulan;
        //     }
        //     window.location.href = url;
        // });

        // // Function to update the "Semua Tahun" option based on the selected year
        // function updateSemuaTahunOption(selectedYear) {
        //     var semuaTahunOption = document.getElementById('semua-bulan-option');
        //     if (!selectedYear) {
        //         semuaTahunOption.selected = true;
        //     }
        // }

        // // Initial call to update the "Semua Tahun" option based on the selected year
        // var selectedYear = new URLSearchParams(window.location.search).get('bulan');
        // updateSemuaTahunOption(selectedYear);
    </script>
    <!-- /.row -->
@endsection
