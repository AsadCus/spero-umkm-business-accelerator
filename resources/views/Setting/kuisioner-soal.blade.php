@extends('index')

@section('title', 'Soal "Kuisioner UMKM"')

@section('content')
    <h2 class="section-title d-flex">
        <div>
            <span id="aktual-skor">60</span>
            <span> / </span>
            <span id="limit-skor">100</span>
        </div>
    </h2>

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
                            aria-label="Task Name: activate to sort column ascending" style="width:208.203px;">Soal</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Progress"
                            style="width:  149.078px ;">Jenis Jawaban</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Members"
                            style="width: 78.7344px;">Skor</th>
                        <th class="sorting" tabindex="0" aria-controls="table-1" rowspan="1" colspan="1"
                            aria-label="Due Date: activate to sort column ascending" style="width: 89.0938px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr role="row" class="odd">
                        <td class="text-center">1</td>
                        <td>Soal UMKM 1</td>
                        <td>Text</td>
                        <td contenteditable="true" class="editable editable-skor">30</td>
                        <td>
                            <div class="btn-group mb-2">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item edit-button" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="text-center">2</td>
                        <td>Soal UMKM 2</td>
                        <td>Text</td>
                        <td contenteditable="true" class="editable editable-skor">30</td>
                        <td>
                            <div class="btn-group mb-2">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item edit-button" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButtons = document.querySelectorAll('.edit-button');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    updateRow(this);
                });
            });
        });

        function updateRow(button) {
            var row = button.parentNode.parentNode;
            var scoreCells = document.querySelectorAll('.editable-skor');
            var totalScore = 0;
            var previousValues = [];

            scoreCells.forEach(function(cell) {
                totalScore += parseInt(cell.innerText);
                previousValues.push(cell.innerText);
            });

            var limitScore = parseInt(document.getElementById('limit-skor').innerText);

            if (totalScore > limitScore) {
                scoreCells.forEach(function(cell, index) {
                    cell.innerText = previousValues[index];
                });
                alert("Total skor melebihi limit!");
            } else {
                document.getElementById('aktual-skor').innerText = totalScore;
            }
        }
    </script>
@endsection
