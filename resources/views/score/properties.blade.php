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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hovered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">Input</th>
                                        <th class="text-center" scope="col">Score</th>
                                        <th class="text-center" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($dataPropertyScore) < 0)
                                        @foreach ($dataPropertyScore as $key => $value)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $value['name'] }}</td>
                                                <td class="text-center">
                                                    @if ($value['parameter'] == 'true' || $value['parameter'] == 'false')
                                                        {{ $value['parameter'] == 'false' ? 'Tidak Terisi' : 'Terisi' }}
                                                    @else
                                                        {{ $value['parameter'] }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-danger text-white delete-logic"
                                                        data-href="{{ url('/') }}/delete-logic/{{ $data->id }}/{{ $key }}">
                                                        <i class="fa fa-times"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
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
            aria-labelledby="tambahDataLabel" aria-hidden="true">
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
                            <label for="parameter" class="form-label">Parameter Output <span
                                    class="text-danger text-bold">*</span></label>
                            <br>
                            Terisi : <input type="radio" class="paramTrig" name="parameter" value="true" required><br>
                            Tidak : <input type="radio" class="paramTrig" name="parameter" value="false">
                            <div id="parameterHelp" class="form-text"></div>
                        </div>
                        <div class="mb-3" id="valParam" style="display: none">
                            <label for="parameter" class="form-label">Value Parameter :</label>
                            <select class="form-control" name="valueParam">
                                <option value="">-- Pilih --</option>
                            </select>
                            <div id="parameterHelp" class="form-text"></div>
                        </div>
                        <div class="text-right" style="font-weight:bold"> Note : <span
                                class="text-danger text-bold">*</span> Wajib Isi</div>
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
        const formJson = JSON.parse($("#formJson").val());
        $(".paramTrig").change(function() { // bind a function to the change event
            var select = $(".select2 option:selected").text()
            if (($(this).is(":checked")) && (select.indexOf("[select]") !== -1)) { // check if the radio is checked
                if ($(this).val() == 'true') {
                    let arrOption = formJson[$(".select2 option:selected").attr('data-key')]['select']['options'];
                    $('#valParam select').html('<option value="">-- Pilih Parameter --</option>')
                    $.each(arrOption, function(index, value) {
                        $('#valParam select').append('<option value="' + value['id'] + '">' + value[
                            'name'] + '</option')
                    });
                    $('#valParam').attr('style', '')
                } else {
                    $('#valParam select').html('<option value="">-- Pilih Parameter --</option>')
                    $('#valParam select').val('').trigger('change')
                    $('#valParam').attr('style', 'display:none')
                }
            }
        })

        $(".select2").change(function() {
            var select = $(".select2 option:selected").text()
            // console.log((select.indexOf("[select]") !== -1));
            if (($('.paramTrig:checked').val() == 'true') && (select.indexOf("[select]") !== -
                    1)) { // check if the radio is checked
                let arrOption = formJson[$(".select2 option:selected").attr('data-key')]['select']['options'];
                $('#valParam select').html('<option value="">-- Pilih Parameter --</option>')
                $.each(arrOption, function(index, value) {
                    $('#valParam select').append('<option value="' + value['id'] + '">' + value['name'] +
                        '</option')
                });
                $('#valParam').attr('style', '')
            } else {
                $('#valParam select').html('<option value="">-- Pilih Parameter --</option>')
                $('#valParam select').val('').trigger('change')
                $('#valParam').attr('style', 'display:none')
            }
        })

        $(document).on("click", ".delete-logic", function() {
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

        $(document).ready(function() {
            $('.select2').select2({
                // dropdownParent: $('#tambahData')
            });
        });
    </script>

    <!-- Page Specific JS File -->
@endpush
