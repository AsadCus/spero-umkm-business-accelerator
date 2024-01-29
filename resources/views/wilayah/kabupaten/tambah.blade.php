@extends('layouts.app')
@section('title', 'Form Input Kabupaten')
@section('main')
<div class="main-content">
  <section class="section">
    
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Form Input Kabupaten</h5>
            </div>
            <div class="card-body">
                <form action="{{url('/add-kabupaten')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama Provinsi <span style="color: red">*</span></label>
                        <select class="form-control select2" name="id_provinsi" required>
                            @foreach ($data as $item)
                            <option value="{{ $item->id_provinsi }}">{{ $item->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="form-group">
                            <label>Nama Kabupaten <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="nama_kabupaten" required>
                        </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </section>
</div>

@endsection
