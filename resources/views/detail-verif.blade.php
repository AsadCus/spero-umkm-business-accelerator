@extends('layouts.app')

@section('title', 'Detail Data Kuesioner')

@push('style')
    <style>
        #data-table tbody tr td {
            vertical-align: middle;
        }

        #data-table thead tr th,
        .table th {
            vertical-align: middle !important;
            text-align: center;
        }

        .table:not(.table-sm):not(.table-md):not(.dataTable) td,
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            height: 43px !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="width:80%">Detail Data Kuesioner</h1>
                <div class="float-right; text-right" style="width: 20%;"><strong>Score : </strong> <span
                        class="badge badge-sm badge-success">{{ $data->score }}</span></div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Kuesioner </h2>
                <p class="section-lead">Hasil data responden.</p>
                <div class="card">
                    <div class="card-body">
                        <a data-toggle="collapse" href="#collapseProfil" style="text-decoration:none; color: #000"
                            role="button" s aria-expanded="false" aria-controls="collapseProfil">
                            <strong>Detail Data Profil</strong> :
                        </a>
                        <div class="float-right">
                            <b>Tgl Regist</b> :
                            <span class="badge badge-xs badge-info" style="padding: 7px 12px;font-size:12px"><i
                                    class="fa fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($data->updated_at)->locale('id')->format('j F Y') }}</span>
                            <td></td>

                        </div>
                        <hr>
                        <div class="collapse" id="collapseProfil">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Nama</b> : {{ $data->name }}
                                    <hr />
                                    <b>Email</b> : {{ $data->email }}
                                    <hr />
                                    <b>NIK</b> : {{ $data->nik }}
                                    <hr />
                                    <b>No HP</b> : {{ $data->no_hp }}
                                    <hr />
                                </div>
                                <div class="col-md-4">
                                    <b>Kabupaten</b> : {{ $data->nama_kabupaten ?? '-' }}
                                    <hr />
                                    <b>Kecamatan</b> : {{ $data->nama_kecamatan ?? '-' }}
                                    <hr />
                                    <b>Kelurahan</b> : {{ $data->nama_kelurahan ?? '-' }}
                                    <hr />
                                    <b>Alamat Lengkap</b> :
                                    {{ $data->alamat_lengkap ?? '-' }}
                                    <hr />
                                </div>
                                <div class="col-md-4">
                                    <b>Toko</b> : <span class="badge badge-xs badge-danger"
                                        style="padding: 7px 12px;font-size:12px"><i class="fa fa-store"></i>
                                        {{ $data->nama_usaha }}</span>
                                    <hr />
                                    <b>No Telp</b> : {{ $data->no_telp }}
                                    <hr />
                                    <b>Email Usaha</b> : {{ $data->email_usaha }}
                                    <hr />
                                    <b>NIB</b> : {{ $data->nib }}
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <a data-toggle="collapse" href="#collapseResponden" style="text-decoration:none; color: #000"
                            role="button" s aria-expanded="false" aria-controls="collapseResponden">
                            <strong>Detail Data Responden</strong> :
                        </a>
                        <div class="float-right">
                            <b>Tgl Submit</b> :
                            <span class="badge badge-xs badge-warning" style="padding: 7px 12px;font-size:12px"><i
                                    class="fa fa-calendar"></i>
                                {{ $data->email_verified_at != null? \Carbon\Carbon::parse($data->email_verified_at)->locale('id')->format('j F Y'): '' }}</span>
                            <td></td>

                        </div>
                        <hr>
                        <div class="in collapse show" id="collapseResponden">
                            <div class="row">
                                {!! $data->html !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve'
            });
        });
    </script>

    <!-- Page Specific JS File -->
@endpush
