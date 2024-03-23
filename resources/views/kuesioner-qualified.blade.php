@extends('layouts.app')

@section('title', 'Kuesioner Qualified')

@push('style')
    <style>
        tbody tr td,
        thead tr th {
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="width:85%">Kuesioner - Qualified</h1>
                <div class="float-right">
                    <form action="/export-kuesioner-qualified" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_provinsi" name="id_prov">
                        <input type="hidden" id="id_kabupaten" name="id_kab">
                        <input type="hidden" id="id_kecamatan" name="id_kec">
                        <input type="hidden" id="id_kelurahan" name="id_kel">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Export
                            Excel</button>
                    </form>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">List Kuesioner - Qualified</h2>
                <p class="section-lead">List daftar responden yang sudah mengisi kuesioner dengan score tertinggi.</p>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex mt-3">
                            <div class="form-group">
                                <select class="form-control select2" id="provinsi">
                                    <option selected disabled>-- Pilih Provinsi --</option>
                                    @foreach ($provinsi as $listProvinsi)
                                        <option value="{{ $listProvinsi->id_provinsi }}">{{ $listProvinsi->nama_provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ml-2">
                                <select class="form-control select2" id="kabupatens">
                                    <option selected disabled>-- Pilih Kabupaten --</option>
                                </select>
                            </div>
                            <div class="form-group ml-2 mr-2">
                                <select class="form-control select2" id="kecamatans">
                                    <option selected disabled>-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control select2" id="kelurahans">
                                    <option selected disabled>-- Pilih Kelurahan --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-x">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col" style="width: 20%">Nama Bisnis</th>
                                        {{-- <th scope="col">Use?</th> --}}
                                        <th scope="col">Wilayah</th>
                                        <th scope="col">Score</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-verif">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        function filterData() {
            let value = $(document).find('#date').val();
            let value_second = $(document).find('#date_second').val();
            window.location.href = "{{ url('/') }}/showPenjualan?date=" + value + "&date_second=" + value_second;
        }

        function exportData() {
            let value = $(document).find('#date').val();
            let value_second = $(document).find('#date_second').val();
            const url = "{{ url('/') }}/exportPenjualan?date=" + value + "&date_second=" + value_second;
            window.open(url, '_blank');
        }

        $(document).ready(function() {
            $('.select2').select2();

            var table = $('#table-x').DataTable({
                processing: true,
                ordering: false,
                searching: true,
                serverSide: true,
                ajax: {
                    url: '{{ url()->current() }}',
                    data: function(data) {
                        data.id_prov = $('#id_provinsi').val(),
                            data.id_kab = $('#id_kabupaten').val(),
                            data.id_kec = $('#id_kecamatan').val(),
                            data.id_kel = $('#id_kelurahan').val()
                    }
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'nama_usaha',
                        render: function(data) {
                            return '<label class="badge badge-sm badge-dark"><i class="fa fa-tag"></i> ' +
                                data + '</label>'
                        }
                    },
                    // {
                    //     data: 'import',
                    //     render: function(data) {
                    //         if (data == 0) {
                    //             var use =
                    //                 '<span class="badge badge-dark"><i class="fa fa-desktop"></i>App</span>'
                    //         } else {
                    //             var use =
                    //                 '<span class="badge badge-danger badge-sm"><iclass="fa-brands fa-google-plus-g"></i> form</span>'
                    //         }
                    //         return use;
                    //     }
                    // },
                    {
                        data: 'wilayah'
                    },
                    {
                        data: 'sumScore'
                    },
                    {
                        data: null,
                        render: function(data, row) {
                            return `<a type="button" target="_blank" href="detail-data/${data.id}" class="btn btn-sm btn-dark"><i class="fa fa-search"></i></a>
                            <button type="button" data-href="{{ url('/') }}/rollback-data/${data.id_user}" class="btn btn-sm btn-danger rollback"><i class="fa fa-reply"></i> UnVerif</button>`;
                            // return `<a type="button" target="_blank" href="detail-data/${data.id}" class="btn btn-sm btn-dark"><i class="fa fa-search"></i></a>&nbsp;
                        // <a class="btn btn-sm btn-primary" href="/preview-pdf/${data.id}"><i class="fas fa-file-pdf"></i></a>
                        // <a class="btn btn-sm btn-success" href="/send-pdf/${data.id}"><i class="fas fa-paper-plane"></i></a>
                        // <button type="button" data-href="{{ url('/') }}/rollback-data/${data.id_user}" class="btn btn-sm btn-danger rollback"><i class="fa fa-reply"></i> Rollback</button>`;
                        },
                    },
                ],
            });

            // filter provinsi
            $('#provinsi').on('change', function() {
                var provinsi_id = this.value;
                $('#kabupatens').html('<option value="" selected disabled>-- Pilih Kabupaten --</option>');
                $('#kecamatans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
                $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kelurahan --</option>');
                $('#table-verif').html('');
                $('#id_provinsi').val(provinsi_id);
                $('#id_kabupaten').val('');
                $('#id_kecamatan').val('');
                $('#id_kelurahan').val('');

                $.ajax({
                    url: "/get-kabupaten/" + provinsi_id,
                    method: 'get',
                    success: function(res) {
                        console.log(res);
                        $.each(res.kabupaten, function(key, value) {
                            $('#kabupatens').append('<option value="' + value
                                .id_kabupaten + '">' + value
                                .nama_kabupaten + '</option>');
                        });
                        table.draw();
                    }
                });
            });

            // filter kabupaten
            $('#kabupatens').on('change', function() {
                var kabupatens_id = this.value;
                $('#kecamatans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
                $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kelurahan --</option>');
                $('#table-verif').html('');
                $('#id_kabupaten').val(kabupatens_id);
                $('#id_kecamatan').val('');
                $('#id_kelurahan').val('');

                $.ajax({
                    url: "/get-kecamatan/" + kabupatens_id,
                    method: 'get',
                    success: function(res) {
                        // console.log(res);
                        $.each(res.kecamatan, function(key, value) {
                            $('#kecamatans').append('<option value="' + value
                                .id_kecamatan + '">' + value
                                .nama_kecamatan + '</option>');
                        });
                        table.draw();
                    }
                });
            });

            // filter kecamatan
            $('#kecamatans').on('change', function() {
                var kecamatans_id = this.value;
                $('#id_kecamatan').val(kecamatans_id);
                $('#id_kelurahan').val('');
                $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kelurahan --</option>');

                $.ajax({
                    url: "/get-kelurahan/" + kecamatans_id,
                    method: 'get',

                    success: function(res) {
                        // console.log(res);
                        $.each(res.kelurahan, function(key, value) {
                            $('#kelurahans').append('<option value="' + value
                                .id_kelurahan + '">' + value
                                .nama_kelurahan + '</option>');
                        });
                        table.draw();
                    }
                });
            });

            // filter kelurahan
            $('#kelurahans').on('change', function() {
                var kelurahans_id = this.value;
                $('#id_kelurahan').val(kelurahans_id);
                table.draw();
            });
        });

        $(document).on("click", ".rollback", function() {
            let href = $(this).attr('data-href');
            Swal.fire({
                title: 'Apakah anda yakin?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Iya',
                denyButtonText: `Tidak, kembali`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Data dirollback!', '', 'success')
                    window.location.replace(href);
                } else if (result.isDenied) {
                    Swal.fire('Aksi rollback dibatalkan', '', 'info')
                }
            })
        });
    </script>
    <!-- Page Specific JS File -->
@endpush
