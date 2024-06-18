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
                        {{-- <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Periode Tahun</label>
                            <div class="col-10">
                                <input class="form-control" name="periode" type="number" min="1" value=""
                                    id="periode" required placeholder="Contoh : 2024">
                            </div>
                        </div> --}}
                        @foreach ($criteria as $criterias)
                            <div class="form-group row">
                                <label for="example-email-input" class="col-2 col-form-label">Nilai
                                    {{ $criterias->information }} ({{ $criterias->criteria }})</label>
                                <div class="col-10">
                                    <input class="form-control" name="{{ $criterias->criteria }}" type="number"
                                        min="1" max="100" value="0" id="{{ $criterias->criteria }}"
                                        required>
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
                            <label for="example-email-input" class="col-2 col-form-label">Pilih Pegawai</label>
                            <div class="col-10">
                                <select name="pegawai_id" class="form-control" id="pegawai_id" required>
                                    <option value="" disabled selected>Pilih Pegawai</option>


                                    @foreach ($pegawai as $list)
                                        <option value="{{ $list->id }}"
                                            {{ $list->id == $penilaian->pegawai_id ? 'selected' : '' }}>
                                            {{ $list->nama_pegawai }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Pilih Periode</label>
                            <div class="col-10">
                                <select name="pegawai_id" class="form-control" id="pegawai_id" required>
                                    <option value="" disabled selected>Pilih Periode</option>
                                    <option value="2019" disabled selected>2019</option>
                                    <option value="2020" disabled selected>2020</option>
                                    <option value="2021" disabled selected>2021</option>
                                    <option value="2022" disabled selected>2022</option>
                                    <option value="2023" disabled selected>2023</option>
                                    <option value="2024" disabled selected>2024</option>




                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Periode Tahun</label>
                            <div class="col-10">
                                <input class="form-control" name="periode" type="number" min="1"
                                    value="{{ $penilaian->periode }}" id="periode" required>
                            </div> --}}
                    </div>
                    @foreach ($criteria as $criterias)
                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Nilai
                                {{ $criterias->information }} ({{ $criterias->criteria }})</label>
                            <div class="col-10">
                                <input class="form-control" name="{{ $criterias->criteria }}" type="number" min="1"
                                    max="100" value="{{ $penilaian->{strtolower($criterias->criteria)} ?? 0 }}"
                                    id="{{ $criterias->criteria }}" required>
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
    <script>
        document.getElementById('urgensi_cuti_id').addEventListener('change', function() {
            var selectedId = this.value;
            console.log(selectedId)
            if (selectedId) {
                fetch('/urgensi_cuti_detail/' + selectedId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // console.log(data.data)
                            document.getElementById('lama_cuti').value = data.data.lama_cuti;
                            updateTanggalAkhir();

                        } else {
                            console.error('Data tidak ditemukan');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Hitung tanggal akhir berdasarkan tanggal awal dan lama cuti
        function updateTanggalAkhir() {
            var tanggalAwal = document.getElementById('tanggal_awal').value;
            var lamaCuti = parseInt(document.getElementById('lama_cuti').value);
            if (tanggalAwal && lamaCuti) {
                var dateAwal = new Date(tanggalAwal);
                dateAwal.setDate(dateAwal.getDate() + lamaCuti);
                var tanggalAkhir = dateAwal.toISOString().split('T')[0];
                document.getElementById('tanggal_akhir').value = tanggalAkhir;
            }
            console.log("tanggalawal", tanggalAwal);
            console.log("lamaCuti", lamaCuti);
        }

        // Panggil fungsi updateTanggalAkhir saat tanggal_awal berubah
        document.getElementById('tanggal_awal').addEventListener('change', updateTanggalAkhir);
    </script>

@endsection
