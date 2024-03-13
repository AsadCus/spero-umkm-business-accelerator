@extends('layouts.app')

@section('title', 'Setting Score')

@push('style')
    <style>
        #data-table tbody tr td {
            vertical-align: middle;
        }

        #data-table thead tr th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="width:87%">Set Score</h1>
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i
                            class="fa fa-plus"></i> Tambah Data</button>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">List Setting Score</h2>
                <p class="section-lead">List daftar form yang terdapat sistem score.</p>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">Kuesioner</th>
                                        <th class="text-center" scope="col">Score Limit</th>
                                        <th class="text-center" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $key => $listData)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $listData->form->title }}</td>
                                            <td class="text-center">{{ $listData->max_score }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-dark btn-sm"
                                                    href="set-score/show/{{ $listData->form->id }}">
                                                    <i class="fa fa-search"></i> Show
                                                </a>
                                                &nbsp;
                                                <button type="button" class="btn btn-warning btn-sm edit-score"
                                                    data-toggle="modal" data-target="#editData"
                                                    data-id="{{ $listData->id }}" data-score="{{ $listData->max_score }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                                &nbsp;
                                                <button type="button" class="btn btn-danger btn-sm hapus-score"
                                                    data-href="set-score/delete/{{ $listData->id }}">
                                                    <i class="fa fa-times"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="4">Tidak Ada Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Modal -->
    <form action="set-score/store" method="POST">
        <div class="modal fade" id="tambahData" aria-labelledby="tambahData" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDataLabel">Tambah Data Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="form" class="form-label">
                                Form
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <select class="form-control" name="form_id" id="form" required>
                                <option value="">-- Pilih --</option>
                                @forelse ($forms as $keyForm => $valueForm)
                                    <option value="{{ $valueForm->id }}">{{ $valueForm->title }}</option>
                                @empty
                                    <option value="" disabled>Empty</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="score" class="form-label">
                                Max Score
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <input type="number" class="form-control" id="score" name="max_score"
                                aria-describedby="scoreHelp" required>
                        </div>
                        <hr />
                    </div>
                    <div class="modal-footer pt-1 justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="set-score/update/{{ $listData->id }}" method="POST">
        <div class="modal fade" id="editData" aria-labelledby="editData" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataLabel">Edit Data Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="max-score" class="form-label">
                                Max Score
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <input type="number" class="form-control" id="max-score" name="max_score"
                                aria-describedby="scoreHelp" value="" required>
                        </div>
                        <hr />
                    </div>
                    <div class="modal-footer pt-1 justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Page Specific JS File -->

    <script>
        $(document).on("click", ".hapus-score", function() {
            let href = $(this).attr('data-href');
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus ini?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Iya',
                denyButtonText: `Tidak, kembali`,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Terhapus!', '', 'success')
                    window.location.replace(href);
                } else if (result.isDenied) {
                    Swal.fire('Aksi hapus dibatalkan', '', 'info')
                }
            })
        });

        $(document).on("click", ".edit-score", function() {
            let id = $(this).data('id');
            let score = $(this).data('score');
            $('#editData').find('#max-score').val(score);
            $('#editData').find('form').attr('action', 'set-score/update/' + id);
        });
    </script>
@endpush
