@extends('layouts.app')

@section('title', 'Kuesioner Score')

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
                <h1 style="width:87%">Kuesioner Skor</h1>
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">List Kuesioner - Score</h2>
                <p class="section-lead">List daftar kuesioner yang terdapat sistem Score.</p>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kuesioner</th>
                                        <th scope="col">Score Limit</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $key => $listData)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $listData->form->title }}</td>
                                            <td>{{ $listData->max_score }}</td>
                                            <td>
                                                <a class="btn btn-dark btn-sm"
                                                    href="kuesioner-skor/show/{{ $listData->id }}">
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
                                                    data-href="kuesioner-skor/delete/{{ $listData->id }}">
                                                    <i class="fa fa-times"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
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
    <form action="kuesioner-skor/store" method="POST">
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
    @if (count($data) > 0)
        <form action="kuesioner-skor/update/{{ $listData->id }}" method="POST">
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
    @endif
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>

    <script>
        $("#table").dataTable({});
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
            $('#editData').find('form').attr('action', 'kuesioner-skor/update/' + id);
        });
    </script>
    <!-- Page Specific JS File -->
@endpush
