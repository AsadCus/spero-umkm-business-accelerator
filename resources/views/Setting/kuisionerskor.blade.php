@extends('index')

@section('title', 'Kuisioner Skor')

@section('content')
    {{-- <table class="table">
        <thead style="background-color: #6777ef !important;">
        <tr class="text-center">
            <th class="text-white" scope="col">No</th>
            <th class="text-white" scope="col">Soal</th>
            <th class="text-white" scope="col">Jenis Jawaban</th>
            <th class="text-white" scope="col">Jawaban</th>
            <th class="text-white" scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody class="table-group-divider text-center">
        <tr>
            <th scope="row">1</th>
            <td>UMKM Mark</td>
            <td>96</td>
        </tr>
        </tbody>
    </table> --}}

    <h2 class="section-title">Limit Skor : 100</h2>

  <div class="row"><div class="col-sm-12"><table class="table table-striped dataTable no-footer" id="table-1" role="grid" aria-describedby="table-1_info">
    <thead>                                 
    <tr role="row"><th class="text-center sorting_asc" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="
          #
        : activate to sort column descending" style="width: 24.4375px;">
          No
        </th>
        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-label="Task Name: activate to sort column ascending" style="width:208.203px;">Soal</th>
        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Progress" style="width:  149.078px ;">Jenis Jawaban</th>
        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Members" style="width: 78.7344px;">Status</th>
        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Members" style="width: 78.7344px;">Skor</th>
        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1" aria-label="Due Date: activate to sort column ascending" style="width: 89.0938px;">Aksi</th>
    </tr>
    </thead>
    <tbody>                                 
      
    <tr role="row" class="odd">
        <td class="sorting_1">
          1
        </td>
        <td>Soal</td>
        {{-- <td class="align-middle">
          <div class="progress" data-height="4" data-toggle="tooltip" title="" data-original-title="100%" style="height: 4px;">
            <div class="progress-bar bg-success" data-width="100%" style="width: 100%;"></div>
          </div>
        </td>
        <td>
          <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
        </td> --}}
        <td>Jenis Jawaban</td>
        <td class="sorting_2"><div class="badge badge-success">Publish</div></td>
        <td class="sorting_2" contenteditable="true" class="editable">80</td>
        <td>
            <div class="btn-group mb-2">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Aksi
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Publish</a>
                  <a class="dropdown-item" href="#">Unpublish</a>
                </div>
            </div>
        </td>
        {{-- <td><div class="badge badge-success">Completed</div></td> --}}
        {{-- <td><a href="#" class="btn btn-secondary">Detail</a></td> --}}
      </tr>
    </tbody>
  </table>
</div>
</div>

<script>
    function updateRow(button) {
        var row = button.parentNode.parentNode;
        var name = row.querySelector('.editable:nth-child(1)').innerText;
        var email = row.querySelector('.editable:nth-child(2)').innerText;
        console.log("Nama: " + name + ", Email: " + email);
        // Di sinilah Anda dapat mengirim data ke backend atau melakukan tindakan lainnya.
        // Misalnya, Anda bisa menggunakan AJAX untuk mengirim data ke server.
    }
</script>
@endsection