@extends('index')

@section('title', 'Tambah Kuisioner Kurasi')

@section('content')

<div class="form-group">
    <label>Pilih Soal Kuisioner</label>
    <select class="form-control">
      <option>Soal Kuisioner 1</option>
      <option>Soal Kuisioner 2</option>
      <option>Soal Kuisioner 3</option>
    </select>
  </div>

<div class="form-group">
    <label>Masukkan Soal</label>
    <input type="text" class="form-control">
  </div>

  <div class="d-flex justify-content-end">
    <a href="/kuisionerkurasi" class="btn btn-primary">Simpan</a>
  </div>


@endsection