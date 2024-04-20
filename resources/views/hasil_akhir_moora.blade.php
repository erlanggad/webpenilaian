@extends('template')

@section('title', '- Manage Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-12">
                <h4 class="page-title">Hasil Akhir Moora</h4>
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
                    {{-- <div> --}}
                    <h3 class="box-title m-b-0" style="font-size:17px">Rumus</h3>
                    {{-- </div> --}}
                    <div class="col-md-8 mb-4">
                        <img src="{{ asset('rumus/moora_4.png') }}" alt="" style="width: 50%">

                    </div>
                    {{-- <div class="col-md-3 mb-4">
                        <label for="bulan">Filter Bulan:</label>
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
                                    <th>Skor Moora</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data as $item)
                                    {{-- <?php dd($role); ?> --}}
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>{{ $item['skor_akhir'] }}</td>


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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectBulan = document.getElementById('bulan');

            if (selectBulan) {
                selectBulan.addEventListener('change', function() {
                    var selectedValue = this.value;
                    var currentUrl = window.location.href;

                    if (selectedValue === '') {
                        // Jika pengguna memilih "Semua Bulan", hapus parameter bulan dari URL
                        var newUrl = removeQueryStringParameter(currentUrl, 'bulan');
                    } else {
                        // Jika pengguna memilih bulan lain, perbarui parameter bulan di URL
                        var newUrl = updateQueryStringParameter(currentUrl, 'bulan', selectedValue);
                    }

                    window.location.href = newUrl;
                });
            }

            // Function to update query string parameter
            function updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }

            // Function to remove query string parameter
            function removeQueryStringParameter(uri, key) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + '$2');
                } else {
                    return uri;
                }
            }
        });
    </script>


@endsection
