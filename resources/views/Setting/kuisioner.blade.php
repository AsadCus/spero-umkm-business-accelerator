@extends('index')

@section('title', 'Kuisioner')

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
                            aria-label="Task Name: activate to sort column ascending" style="width: 149.078px;">Nama</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Progress"
                            style="width: 78.7344px;">Status</th>
                        {{-- <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Progress"
                            style="width: 78.7344px;">Jenis Jawaban</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Members"
                            style="width: 208.203px;">Jawaban</th> --}}
                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1"
                            aria-label="Due Date: activate to sort column ascending" style="width: 89.0938px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <tr role="row" class="odd">
                        <td class="text-center">1</td>
                        <td>Kuesioner UMKM</td>
                        <td>
                            <div class="badge badge-success">Publish</div>
                        </td>
                        {{-- <td>Jenis Jawaban</td>
                        <td>Jawaban</td> --}}
                        <td>
                            <div class="btn-group mb-2">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Publish</a>
                                    <a class="dropdown-item" href="#">Unpublish</a>
                                    <a class="dropdown-item" href="/show/kuisioner-soal">Set Skor</a>
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
@endsection
