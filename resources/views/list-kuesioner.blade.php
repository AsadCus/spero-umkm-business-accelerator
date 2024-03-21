@extends('layouts.app')

@section('title', 'List Kuesioner')

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
                <h1 style="width:87%">List Kuesioner</h1>
                <div class="float-right">
                    {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button> --}}
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">List Kuesioner </h2>
                <p class="section-lead">List Kuesioner yang aktif.</p>
                <div class="row-fluid">
                    @forelse ($listKuesioner as $item)
                        <div class="card col-md-4">
                            <div class="card-body" style="padding:20px 10px;">
                                <strong class="text-dark">{{ $item->title }}</strong>
                                <small class="float-right"><i class="fa fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->format('j F Y') }}</small>
                                <hr />
                                <p>Desc : {{ $item->description == '' ? '-' : $item->description }}</p>
                                {{-- <p>Jumlah Data : {{$item->description == '' ? '-' : $item->description}}</p> --}}
                                <div class="text-center">
                                    <a class="btn btn-success btn-sm" target="_blank"
                                        href="{{ url('/') }}/export-kuesioner/{{ $item->id }}"><i
                                            class="fa fa-file-excel"></i> Export Excel</a>
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ url('/') }}/kuesioner/{{ $item->id }}">Data Kuesioner <i
                                            class="fa fa-arrow-right"></i></a>
                                    <a class="btn btn-dark btn-sm"
                                        href="{{ url('/kuesioner-skor/show/' . $item->score->id) }}">Set
                                        Score <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card col-md-12">
                            <div class="card-body text-center">
                                No Data
                            </div>
                        </div>
                    @endforelse
                </div>

        </section>

    </div>
@endsection

@push('scripts')
    <!-- Page Specific JS File -->
@endpush
