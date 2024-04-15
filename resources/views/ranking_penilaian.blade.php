@extends('template')

@section('title', '- Manage Penilaian')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Ranking Penilaian Kinerja</h4>
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
                                    <th>Skor Akhir</th>
                                    {{-- <th>Verifikasi Oleh</th> --}}
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
                                    <th>Skor Akhir</th>
                                    {{-- <th>Verifikasi Oleh</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
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
                                    <th>Skor Akhir</th>
                                    {{-- <th>Verifikasi Oleh</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
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
