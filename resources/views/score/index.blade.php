@extends('layouts.app')

@section('title', 'Score')

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
                <h1 style="width:87%">Score</h1>
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i
                            class="fa fa-plus"></i> Tambah Data</button>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">List Score</h2>
                <p class="section-lead">List daftar Score.</p>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">Nama</th>
                                        <th class="text-center" scope="col">Score Limit</th>
                                        <th class="text-center" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $key => $value)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            {{-- <td class="text-center">{{ $value->title }}</td> --}}
                                            <td class="text-center">100</td>
                                            <td class="text-center">
                                                <a class="btn btn-warning btn-sm" href="set-logic/{{ $value->id }}"><i
                                                        class="fa fa-edit"></i> Edit</a> &nbsp;
                                                <button type="button" class="btn btn-danger btn-sm hapus-score"
                                                    data-href="delete-level/{{ $value->id }}"><i class="fa fa-times"></i>
                                                    Hapus</button>
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
    <form action="add-level" method="POST">
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
                            <label for="nama" class="form-label">Nama <span
                                    class="text-danger text-bold">*</span></label>
                            <input type="nama" class="form-control" id="nama" name="nama"
                                aria-describedby="namaHelp" required>
                            <div id="namaHelp" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level <span
                                    class="text-danger text-bold">*</span></label>
                            <select class="form-control" name="level" id="level" required>
                                <option value="">-- Pilih --</option>
                                <option value="1">Beginner</option>
                                <option value="2">Observer</option>
                                <option value="3">Adopter</option>
                                <option value="4">Leader</option>
                            </select>
                            <div id="levelHelp" class="form-text"></div>
                        </div>
                        <hr />
                    </div>
                    <div class="modal-footer pt-1 justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
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
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Terhapus!', '', 'success')
                    window.location.replace(href);
                } else if (result.isDenied) {
                    Swal.fire('Aksi hapus dibatalkan', '', 'info')
                }
            })
        });
    </script>
@endpush
