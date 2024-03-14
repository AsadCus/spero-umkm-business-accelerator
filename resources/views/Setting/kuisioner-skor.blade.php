@extends('index')

@section('title', 'Kuisioner Skor')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped dataTable no-footer" id="table-1" role="grid"
                aria-describedby="table-1_info">
                <thead>
                    <tr role="row">
                        <th class="text-center sorting_asc" tabindex="0" aria-controls="table-1" rowspan="1"
                            colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending"
                            style="width: 24.4375px;">
                            No
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1"
                            aria-label="Task Name: activate to sort column ascending" style="width:208.203px;">Kuisioner
                        </th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Members"
                            style="width: 78.7344px;">Status</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Members"
                            style="width: 78.7344px;">Limit Skor</th>
                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1"
                            aria-label="Due Date: activate to sort column ascending" style="width: 89.0938px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <tr role="row" class="odd">
                        <td class="text-center">1</td>
                        <td>Kuisioner UMKM</td>
                        <td>
                            <div class="badge badge-success">Publish</div>
                        </td>
                        <td contenteditable="true" class="editable">100</td>
                        <td>
                            <div class="btn-group mb-2">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/show/kuisioner-soal">Show</a>
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
