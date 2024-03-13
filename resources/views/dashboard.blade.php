@extends('layouts.app')

@section('title', 'Dashboard')

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
                <h1 style="width:87%">Dashboard</h1>
                <div class="float-right">
                    {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button> --}}
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts')
    <!-- Page Specific JS File -->
@endpush
