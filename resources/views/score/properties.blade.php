@extends('layouts.app')

@section('title', 'Setting Score ' . $dataForm->title)

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
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="width:87%">Setting Input Score "{{ $dataForm->title }}"</h1>
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Logic Score "{{ $dataForm->title }}"</h2>
                <p class="section-lead">List logic untuk mendapatkan score dari input serta parameter output yang
                    ditargetkan.</p>
                <div class="card">
                    <div class="card-body">
                        <strong class="text-dark">Score {{ $score['sum'] }} / {{ $score['limit'] }} </strong>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hovered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">Input</th>
                                        <th class="text-center" scope="col">Parameter</th>
                                        <th class="text-center" scope="col">Score</th>
                                        <th class="text-center" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($dataPropertyScore) > 0)
                                        @foreach ($dataPropertyScore as $keyPropertyScore => $list)
                                            <tr>
                                                <td class="text-center">{{ $keyPropertyScore + 1 }}</td>
                                                <td class="text-center">{{ $list->name }} [{{ $list->type }}]</td>
                                                <td class="text-center">
                                                    @if (count($list->logic) > 0)
                                                        {{ $list->logic[0]->parameter == 'false' ? 'Tidak Terisi' : 'Terisi' }}
                                                    @else
                                                        Empty
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if (count($list->logic) > 0)
                                                        @if ($list->type == 'select')
                                                            <select class="form-control">
                                                                @foreach ($list->logic as $keyLogic => $listLogic)
                                                                    <option value="{{ $listLogic->score }}">
                                                                        {{ $listLogic->name }} - {{ $listLogic->score }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            {{ $list->logic[0]->score }}
                                                        @endif
                                                    @else
                                                        Empty
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-danger text-white delete-logic"
                                                        data-href="{{ url('/') }}/set-score/logic/delete/{{ $list->id }}">
                                                        <i class="fa fa-times"></i> Hapus
                                                    </a>
                                                    <button type="button" class="btn btn-warning text-white edit-logic"
                                                        data-toggle="modal" data-target="#editData"
                                                        data-url={{ route('set-score.logic.edit', $list->id) }}>
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="1">#</td>
                                            <td colspan="4">Tidak ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Modal -->
    <form action="{{ route('set-score.logic.store') }}" method="POST">
        <div class="modal fade" id="tambahData" data-backdrop="static" role="dialog" data-keyboard="false"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="tambahDataLabel">Tambah Data Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" class="hidden" value="{{ $dataForm->id }}">
                        <div class="mb-3">
                            <label for="input" class="form-label">Input <span
                                    class="text-danger text-bold">*</span></label>
                            <select class="select2" name="input" id="input" style="width: 100%" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($dataJson as $key => $item)
                                    @if ($item['type'] == 'nf-text' || $item['type'] == 'nf-page-break')
                                        @continue
                                    @endif
                                    <option value="{{ $item['id'] }}" data-key="{{ $key }}">
                                        {{ $item['name'] }} <small>[{{ $item['type'] }}]</small></option>
                                @endforeach
                            </select>
                            <textarea name="forms" id="formJson" class="hidden" style="display:none">{{ $dataForm->properties }}</textarea>
                            <div id="inputHelp" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="parameter" class="form-label">Parameter Output
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <br>
                            Terisi : <input type="radio" class="paramTrig" name="parameter" value="true" required><br>
                            Tidak : <input type="radio" class="paramTrig" name="parameter" value="false">
                            <div id="parameterHelp" class="form-text"></div>
                        </div>
                        <div class="mb-3" id="score">
                            <label for="scoreInput" class="form-label">Score :</label>
                            <br>
                            <div id="scoreInput"></div>
                            <div id="scoreInputs"></div>
                            <small id="scoreHelp" class="form-text text-muted">Tidak diisi = 0.</small>
                        </div>
                        <div class="text-right" style="font-weight:bold"> Note :
                            <span class="text-danger text-bold">*</span> Wajib Isi
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
    <form action="{{ route('set-score.logic.update') }}" method="POST">
        <div class="modal fade" id="editData" data-backdrop="static" role="dialog" data-keyboard="false"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="tambahDataLabel">Edit Data Score</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" class="hidden">
                        <div class="mb-3">
                            <label for="parameter" class="form-label">Parameter Output
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <br>
                            Terisi : <input type="radio" class="paramTrig" name="parameter" value="true">
                            <br>
                            Tidak : <input type="radio" class="paramTrig" name="parameter" value="false">
                        </div>
                        <div class="mb-3" id="score">
                            <label for="scoreInput" class="form-label">Score :</label>
                            <br>
                            <div id="scoreInput"></div>
                            <div id="scoreInputs"></div>
                            <small id="scoreHelp" class="form-text text-muted">Tidak diisi = 0.</small>
                        </div>
                        <div class="text-right" style="font-weight:bold"> Note :
                            <span class="text-danger text-bold">*</span> Wajib Isi
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
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Page Specific JS File -->

    <script>
        // plugin
        $(document).ready(function() {
            $('.select2').select2({
                // dropdownParent: $('#tambahData')
            });
        });

        // data
        const formJson = JSON.parse($("#formJson").val());

        // tambah
        $("#tambahData .select2").change(function() {
            var select = $("#tambahData .select2 option:selected").text();
            var hasSelectCondition = select.indexOf("[select]") !== -1;

            if (hasSelectCondition) {
                $('#tambahData #scoreInputs').empty();
                $('#tambahData #scoreInput').empty();
                let arrOption = formJson[$("#tambahData .select2 option:selected").attr('data-key')]['select'][
                    'options'
                ];
                if (arrOption.length > 0) {
                    arrOption.forEach(function(option, index) {
                        let inputHtml =
                            '<div class="input-group mb-3">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text" id="basic-addon1">' + option.name +
                            '</span>' +
                            '</div>' +
                            '<input type="number" class="form-control" name="score[]">' +
                            '</div>';
                        $('#tambahData #scoreInputs').append(inputHtml);
                    });
                }
            } else {
                $('#tambahData #scoreInputs').empty();
                $('#tambahData #scoreInput').empty();
                let inputHtml = '<input type="number" class="form-control" name="score[]">';
                $('#tambahData #scoreInput').append(inputHtml);
            }
        });

        $("#tambahData .select2").change();

        // edit
        $(document).on("click", ".edit-logic", function() {
            let url = $(this).data('url');
            $.get(url, function(data) {
                var propertyScore = data.data;

                $('#editData input[name="id"]').val(data.data.id);

                propertyScore.logic[0].parameter == 'true' ? document.querySelector(
                    '#editData .paramTrig[value="true"]').checked = true : document.querySelector(
                    '#editData .paramTrig[value="false"]').checked = true;

                if (propertyScore.type == 'select') {
                    $('#editData #scoreInputs').empty();
                    $('#editData #scoreInput').empty();
                    propertyScore.logic.forEach(function(option, index) {
                        let inputHtml =
                            '<div class="input-group mb-3">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text" id="basic-addon1">' + option.name +
                            '</span>' +
                            '</div>' +
                            '<input type="number" class="form-control" name="score[]" value="' +
                            option.score + '">' +
                            '</div>';
                        $('#editData #scoreInputs').append(inputHtml);
                    });
                } else {
                    $('#editData #scoreInputs').empty();
                    $('#editData #scoreInput').empty();
                    let inputHtml =
                        '<input type="number" class="form-control" name="score[]" value="' +
                        propertyScore.logic[0].score + '">';
                    $('#editData #scoreInput').append(inputHtml);
                }
            })
        });

        $("#editData .paramTrig").change(function() {
            let id = $('#editData input[name="id"]').val();
            let url = '/set-score/logic/edit/' + id;
            var isChecked = $('#editData .paramTrig:checked').val() == 'true';

            $.get(url, function(data) {
                var propertyScore = data.data;
                var hasSelectCondition = propertyScore.type == 'select';

                if (hasSelectCondition) {
                    $('#editData #scoreInputs').empty();
                    $('#editData #scoreInput').empty();
                    propertyScore.logic.forEach(function(option, index) {
                        let inputHtml =
                            '<div class="input-group mb-3">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text" id="basic-addon1">' + option.name +
                            '</span>' +
                            '</div>' +
                            '<input type="number" class="form-control" name="score[]" value="' +
                            option.score + '">' +
                            '</div>';
                        $('#editData #scoreInputs').append(inputHtml);
                    });
                } else {
                    $('#editData #scoreInputs').empty();
                    $('#editData #scoreInput').empty();
                    let inputHtml =
                        '<input type="number" class="form-control" name="score[]" value="' +
                        propertyScore.logic[0].score + '">';
                    $('#tambahData #scoreInput').append(inputHtml);
                }
            })
        });

        $("#editData paramTrig").change();

        // hapus
        $(document).on("click", ".delete-logic", function() {
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
    </script>
@endpush
