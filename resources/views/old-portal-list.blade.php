@extends('layouts.app')

@section('title', 'Kuesioner Verif')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th, .table th {
        vertical-align: middle !important;
        text-align: center;
    }
</style>
<link rel="stylesheet"
href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet"
href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush
@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">Kuesioner - Verified</h1>
        <div class="float-right">
          <a target="_blank" class="btn btn-sm btn-success" href="export-verif"><i class="fa fa-download"></i> Export Excel</a>
        </div>
      </div>

      <div class="section-body">
        <h2 class="section-title">List Kuesioner - Verified</h2>
        <p class="section-lead">List daftar responden yang sudah mengisi kuesioner dengan status verified.</p>
        <div class="card">
            {{-- <div class="card-header"> --}}
                {{-- <h4>Set Level</h4> --}}
            {{-- </div> --}}
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover dt-responsive nowrap" id="example" style="width: 110%">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            {{-- <th style="width: 10%">Accept UMKM</th> --}}
                            <th>Email</th>
                            {{-- <th>Username</th> --}}
                            <th>Nama Pemilik Usaha</th>
                            <th style="width: 10%">Nama Toko</th>
                            <th>Provinsi</th>
                            <th>No Hp</th>
                            <!-- <th>NIK</th> -->
                            {{-- <th>No Usaha (WA BISNIS)</th>
                            <th>Gender</th>
                            <th>NPWP</th>
                            <th style="width: 10%">Alamat UMKM</th>
                            <th>Rekan Nmp</th> --}}
                            <!-- <th>Jenis Usaha</th> -->
                            <th>Skala Usaha</th>
                            <th>Result Questioner</th>
                            <th>Level UMKM</th>
                            <th>Nama Fasilitator</th>
                            <th>Wilayah Binaan</th>
                            <th>Result Post Test</th>
                            <th>Level UMKM (Post Test)</th>
                            <!-- <th>Referensi</th> -->
                            <th style="width:15%">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            </div>
        </div>
      </div>
    </section>
  </div>

<!-- Modal -->
  <form action="{{route('submit-verif')}}" method="POST">
    @csrf
    <div class="modal fade" id="modalVerif" data-keyboard="false" aria-labelledby="tambahDataLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahDataLabel">Verifikasi User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <input type="hidden" class="form-control hidden" id="id_user" name="id_user" value="" aria-describedby="id_userHelp" required>
          </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-control select2" name="level" id="level" multiple required>
                    <option value="">-- Pilih --</option>
                    <option value="1">Beginner</option>
                    <option value="2">Adapter</option>
                    <option value="3">Observer</option>
                    <option value="4">Legend</option>
                </select>
                <div id="levelHelp" class="form-text"></div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
          </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
" rel="stylesheet">

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
  $("#table").dataTable({});

    $( document ).on( "click", ".doVerif", function() {
      // alert('test');
      let name = $(this).attr('data-name');
      let id = $(this).attr('data-id');
      $('#modalVerif').find('.modal-title').html('Verifikasi User "' + name + '"');
      $('#modalVerif').find('#id_user').val(id);
      $('#modalVerif').modal('show');

    });

    function filterData() {
        let value = $(document).find('#date').val();
        let value_second = $(document).find('#date_second').val();
        window.location.href = "{{url('/')}}/showPenjualan?date=" + value + "&date_second=" + value_second;
    }

    function exportData() {
        let value = $(document).find('#date').val();
        let value_second = $(document).find('#date_second').val();
        const url = "{{url('/')}}/exportPenjualan?date=" + value + "&date_second=" + value_second;
        window.open(url, '_blank');
    }

    $(document).ready(function() {
      $('.select2').select2();
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

    $(document).ready(function() {
        const datatable = $('#example').DataTable({
            // dom: "lBfrtip",
            "responsive": true,
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "aLengthMenu": [
                [25, 50, 75, -1],
                [25, 50, 75, "All"]
            ],
            "iDisplayLength": 25,
            ajax: {
                url: '{{ url("old-portal") }}',
                data: function(d) {
                    d.level = $('#levelUmkm').val();
                    d.wilayah_binaan = $('#wilayahBinaan').val();

                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                // {
                //     data: 'is_accept',
                //     name: 'm_users.is_accept'
                // },
                {
                    data: 'email',
                    name: 'm_users.email'
                },
                // { data : 'username' },
                {
                    data: 'nama_pelapak',
                    name: 'm_users.nama_pelapak'
                },
                {
                    data: 'nama_toko',
                    name: 'm_users.nama_toko'
                },
                {
                    data: 'NAMA_PROP',
                    name: 'm_provinsi.NAMA_PROP'
                },
                {
                    data: 'kontak',
                    name: 'm_users.kontak'
                },
                // {
                //     data: 'nik',
                //     name: 'm_users.nik'
                // },
                // { data : 'no_usaha' },
                // { data : 'gender' },
                // { data : 'npwp' },
                // { data : 'alamat' },
                // { data : 'rekan_nmp' },
                // {
                //     data: 'nama_jenis_usaha',
                //     name: 'm_jenis_usaha.nama_jenis_usaha'
                // },
                {
                    data: 'nama_jenis_umkm',
                    name: 'm_jenis_umkm.nama_jenis_umkm'
                },
                {
                    data: 'result_question',
                    name: 'resultQuestion.result',
                    render: function(data) {
                        if (data) {
                            return data?.result;
                        }

                        return '';
                    }
                },
                {
                    data: 'result_question',
                    name: 'resultQuestion.level_umkm',
                    render: function(data) {
                        if (data) {
                            return data?.level_umkm;
                        }

                        return '';
                    }
                },
                {
                    data: 'fasilitator',
                    name: 'fasilitator.nama_fasil',
                    render: function(data) {
                        if (data) {
                            return data?.nama_fasil;
                        }

                        return '';
                    }
                },
                {
                    data: 'wilayah_bina',
                    name: 'wilayah_bina.wilayah_binaan',
                    render: function(data) {
                        if (data) {
                            return data?.wilayah_binaan;
                        }

                        return '';
                    }
                },

                {
                    data: 'result_question',
                    name: 'resultQuestion.result_postest',
                    render: function(data) {
                        if (data) {
                            return data?.result_postest;
                        }

                        return '';
                    }
                },


                {
                    data: 'result_question',
                    name: 'resultQuestion.level_umkm_postest',
                    render: function(data) {
                        if (data) {
                            return data?.level_umkm_postest;
                        }

                        return '';
                    }
                },

                // {
                //     data: 'result_question',
                //     name: 'resultQuestion.referensi',
                //     render: function(data) {
                //         if (data) {
                //             return data?.referensi;
                //         }

                //         return '';
                //     }
                // },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });


        function onChangeFilter(datatable) {
            if (datatable) {
                datatable.draw();
            } else {
                alert('datatable not found');
            }
        }

        $('#levelUmkm').on('change', function() {
            onChangeFilter(datatable);
        })
        $('#wilayahBinaan').on('change', function() {
            onChangeFilter(datatable);
        })


        // $(".filter").on('change', function() {
        //     levelUmkm = $('#levelUmkm').val()
        //     wilayahBinaan = $('#wilayahBinaan').val()
        //     console.log([levelUmkm])
        //     console.log([wilayahBinaan])
        //     datatable.ajax.url(url).load();
        // });


    });
</script>

<!-- Page Specific JS File -->
@endpush
