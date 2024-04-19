@extends('template')

@section('title', '- Manage Penilaian')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Ranking Penilaian Kinerja</h4>
                <div class="col-md-3 mb-4">
                    <label for="tahun">Filter Periode Tahun</label>
                    @php
                        use App\Models\Penilaian;
                        use App\Models\Jabatan;

                        $uniqueYears = Penilaian::getUniqueYears();
                    @endphp
                    <select class="form-control" id="tahun" name="tahun">
                        <option value="" id="semua-tahun-option" selected disabled>Pilih Tahun</option>
                        @foreach ($uniqueYears as $listYear)
                            <option value="{{ $listYear }}" {{ request('tahun') == $listYear ? 'selected' : '' }}>
                                {{ $listYear }}</option>
                        @endforeach
                    </select>
                </div>
                @if (Session('user')['role'] == 'admin' || Session('user')['role'] == 'Direktur')

                    <div class="col-md-3 mb-4">
                        <label for="tahun">Filter Jabatan</label>
                        @php

                            $jabatan = Jabatan::whereNotIn('id', [1, 2])->get();

                        @endphp
                        <select class="form-control" id="jabatan" name="jabatan">
                            <option value="" id="semua-jabatan-option" selected disabled>Pilih Jabatan</option>
                            @foreach ($jabatan as $listJabatan)
                                <option value="{{ $listJabatan->id }}"
                                    {{ request('jabatan') == $listJabatan->id ? 'selected' : '' }}>
                                    {{ $listJabatan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
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
                    <h2 class="box-title m-b-2">Data Ranking Penilaian Kinerja Karyawan Metode Topsis</h2>
                    <div class="col-md-4"></div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>



                                @foreach ($topsis as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>
                                            {{ $item['skor_akhir'] }}
                                        </td>

                                        {{-- <td>{{$item->verifikasi_oleh}}</td> --}}

                                    </tr>
                                    <?php $no++; ?>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h2 class="box-title m-b-2">Data Ranking Penilaian Kinerja Karyawan Metode Moora</h2>
                    <div class="col-md-4"></div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Skor Akhir</th>
                                    {{-- <th>Verifikasi Oleh</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>

                                @if (request('tahun'))

                                    @foreach ($moora as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item['nama'] }}</td>
                                            <td>
                                                {{ $item['skor_akhir'] }}
                                            </td>

                                            {{-- <td>{{$item->verifikasi_oleh}}</td> --}}

                                        </tr>
                                        <?php $no++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center"> No data available in table
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h2 class="box-title m-b-2">Data Ranking Penilaian Kinerja Karyawan Metode Waspas</h2>
                    <div class="col-md-4"></div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Skor Akhir</th>
                                    {{-- <th>Verifikasi Oleh</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @if (request('tahun'))
                                    @foreach ($waspas as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item['nama'] }}</td>
                                            <td>
                                                {{ $item['skor_akhir'] }}
                                            </td>

                                            {{-- <td>{{$item->verifikasi_oleh}}</td> --}}

                                        </tr>
                                        <?php $no++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center"> No data available in table
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Tambahkan bagian JavaScript di bawah dropdown -->
    <script>
        document.getElementById('tahun').addEventListener('change', function() {
            var tahun = this.value;
            var url = '{{ url()->current() }}';
            console.log(tahun);
            // url += '?tahun=' + tahun;
            // if (
            //     {{ Session('user')['role'] == 'admin' || Session('user')['role'] == 'Direktur' }}
            // ) {
            @if (Session('user')['role'] == 'admin' || Session('user')['role'] == 'Direktur')
                var jabatan = document.getElementById('jabatan').value;


                if (tahun != "" && jabatan != "") {
                    // url += '?tahun=' + tahun;
                    // if (jabatan) {
                    url += '?tahun=' + tahun + '&jabatan=' + jabatan
                    // }
                    window.location.href = url;

                }
                // else {
                //     url += '?tahun=' + tahun;

                // }
                // window.location.href = url;
            @else
                if (tahun) {
                    // url += '?tahun=' + tahun;
                    // if (jabatan) {
                    url += '?tahun=' + tahun
                    // }
                    window.location.href = url;

                }
            @endif

        });

        // Function untuk mengupdate opsi "Semua Tahun" berdasarkan tahun yang dipilih
        function updateSemuaTahunOption(tahunDipilih) {
            var opsiSemuaTahun = document.getElementById('semua-tahun-option');
            if (!tahunDipilih) {
                opsiSemuaTahun.selected = true;
            }
        }

        // Panggil fungsi update "Semua Tahun" berdasarkan tahun yang dipilih
        var tahunDipilih = new URLSearchParams(window.location.search).get('tahun');
        updateSemuaTahunOption(tahunDipilih);

        // Tambahkan event listener untuk memperbarui URL saat opsi "Semua Tahun" dipilih
        document.getElementById('semua-tahun-option').addEventListener('click', function() {
            var url = '{{ url()->current() }}';
            window.location.href = url;
        });

        @if (Session('user')['role'] == 'admin' || Session('user')['role'] == 'Direktur')
            document.getElementById('jabatan').addEventListener('change', function() {
                var jabatan = this.value;
                var tahun = document.getElementById('tahun').value;
                var url = '{{ url()->current() }}';
                if (jabatan) {
                    url += '?tahun=' + tahun + '&jabatan=' + jabatan;
                    // if (tahun) {
                    //     url += '&tahun=' + tahun;
                    // }
                }
                window.location.href = url;
            });

            // Function untuk mengupdate opsi "Semua Jabatan" berdasarkan jabatan yang dipilih
            function updateSemuaJabatanOption(jabatanDipilih) {
                var opsiSemuaJabatan = document.getElementById('semua-jabatan-option');
                if (!jabatanDipilih) {
                    opsiSemuaJabatan.selected = true;
                }
            }

            // Panggil fungsi update "Semua Jabatan" berdasarkan jabatan yang dipilih
            var jabatanDipilih = new URLSearchParams(window.location.search).get('jabatan');
            updateSemuaJabatanOption(jabatanDipilih);

            // Tambahkan event listener untuk memperbarui URL saat opsi "Semua Jabatan" dipilih
            document.getElementById('semua-jabatan-option').addEventListener('click', function() {
                var url = '{{ url()->current() }}';
                window.location.href = url;
            });
        @endif
    </script>


    <!-- /.row -->
@endsection
