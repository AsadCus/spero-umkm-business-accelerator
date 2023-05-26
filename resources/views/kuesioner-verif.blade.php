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
                    <table class="table table-striped table-sm" id="table-1">
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">#</th>
                          <th class="text-center" scope="col">Nama Bisnis</th>
                          <th class="text-center" scope="col">Nama</th>
                          <th class="text-center" scope="col">Form</th>
                          <th class="text-center" scope="col">Level Final</th>
                          <th class="text-center" scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($data as $key => $value)
                          <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td>{{$value->nama_usaha}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->title}}</td>
                            <td class="text-center">{{$value->level}}</td>
                            <td class="text-center">
                              <a type="button" target="_blank" href="detail-data/{{$value->id.'/'.urlencode(base64_encode($value->level))}}" class="btn btn-sm btn-dark"><i class="fa fa-search"></i></a>&nbsp; 
                              <button type="button" data-href="{{url('/')}}/rollback-data/{{$value->id_user}}" class="btn btn-sm btn-danger rollback"><i class="fa fa-reply"></i> Rollback</a>
                            </td>
                          </tr>
                        @empty
                          <tr>
                              <td colspan="6">Tidak Ada Data</td>
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
  <form action="{{route('/submit-verif')}}" method="POST">
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
</script>

<!-- Page Specific JS File -->
@endpush