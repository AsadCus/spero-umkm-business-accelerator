@extends('index')
@section('title', 'Kuisioner Pemrograman')
    
@section('content')
<div class="d-flex justify-content-end">
  <a href="#" class="btn btn-icon icon-left btn-primary my-2 ml-auto"><i class="far fa-edit"></i> Tambah</a>
  </div>
<table class="table">
    <thead  style="background-color: #6777ef !important;">
      <tr class="text-center">
        <th class="text-white" scope="col">No</th>
        <th class="text-white" scope="col">Nama Kuisioner</th>
        <th class="text-white" scope="col">Slug</th>
        <th class="text-white" scope="col">created_at</th>
        <th class="text-white" scope="col">updated_at</th>
        <th class="text-white" scope="col">Status</th>
        <th class="text-white" scope="col">Action</th>
      </tr>
    </thead>
    <tbody class="table-group-divider text-center">
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
        <td>@mdo</td>
        <td><div class="badge badge-success">Published</div></td>
        <td><div class="btn-group mb-2">
          <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Aksi
          </button>
          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a class="dropdown-item" href="#">Edit</a>
            <a class="dropdown-item" href="#">Nonaktifkan</a>
          </div>
        </div></td>
      </tr>
    </tbody>
  </table>

@endsection