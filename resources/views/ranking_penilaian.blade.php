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
            if (tahun) {
                url += '?tahun=' + tahun;
            }
            window.location.href = url;
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
    </script>

    <!-- /.row -->
@endsection
