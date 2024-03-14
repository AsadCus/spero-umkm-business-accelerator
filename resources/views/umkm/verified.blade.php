@extends('index')

@section('title', 'UMKM Verified')

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

    <div class="card-body">
        <div class="table-responsive">
            <div class="row"><div class="col-sm-12"><table class="table table-striped dataTable no-footer" id="table-1" role="grid" aria-describedby="table-1_info">
                <div class="form-group">
                    <label>Pilih Daerah</label>
                    <select class="form-control">
                      <option>Bali</option>
                      <option>Jakarta</option>
                      <option>Bogor</option>
                    </select>
                  </div>
            <div id="table_wrapper" class="dataTables_wrapper no-footer">
                <table class="table table-striped table-sm dataTable no-footer" id="table" role="grid" aria-describedby="table_info">
              <thead>
                <tr role="row"><th class="text-center sorting_asc" scope="col" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 19.8906px;">#</th><th class="text-center sorting" scope="col" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Nama Bisnis: activate to sort column ascending" style="width: 232.328px;">Nama Bisnis</th><th class="text-center sorting" scope="col" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Nama: activate to sort column ascending" style="width: 216px;">Nama</th><th class="text-center sorting" scope="col" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Submit?: activate to sort column ascending" style="width: 72.7812px;">Status</th><th class="text-center sorting" scope="col" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Level: activate to sort column ascending" style="width: 58.3125px;">Skor</th><th class="text-center sorting" scope="col" tabindex="0" aria-controls="table" rowspan="1" colspan="1" aria-label="Aksi: activate to sort column ascending" style="width: 65px;">Aksi</th></tr>
              </thead>
              <tbody>
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                      <tr role="row" class="odd">
                    <td class="sorting_1">3</td>
                    <td>Toko</td>
                    <td>demotestmail</td>

                    <td><a type="button" target="_blank" href="verif-page/3/Tm92aWNl" class="btn btn-sm btn-danger"><i class="fa fa-sign-in"></i> Unverified</a> </td>
                    <td>75</td>
                    
                    <td><a type="button" target="_blank" href="verif-page/3/Tm92aWNl" class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Verif</a> </td>
                  </tr><tr role="row" class="even">
                    <td class="sorting_1">4</td>
                    <td>Marimari_Shop</td>
                    <td>Farhesha Kamil</td>
                    
                    <td><a type="button" target="_blank" href="verif-page/3/Tm92aWNl" class="btn btn-sm btn-success"><i class="fa fa-sign-in"></i> Verified</a> </td>
                    
                    <td>80</td>
                    <td><a type="button" target="_blank" href="verif-page/4/T2JzZXJ2ZXI%3D" class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Verif</a> </td>
                  </tr><tr role="row" class="odd">
                    <td class="sorting_1">5</td>
                    <td>Deng Cell</td>
                    <td>Muhammad Deran</td>
                    
                    <td><a type="button" target="_blank" href="verif-page/3/Tm92aWNl" class="btn btn-sm btn-danger"><i class="fa fa-sign-in"></i> Unverified</a> </td>
                    
                    <td>75</td>
                    <td><a type="button" target="_blank" href="verif-page/5/Tm92aWNl" class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Verif</a> </td>
                  </tr></tbody>
            </table><div class="dataTables_info" id="table_info" role="status" aria-live="polite">Showing 1 to 10 of 14 entries</div><div class="dataTables_paginate paging_simple_numbers" id="table_paginate"><a class="paginate_button previous disabled" aria-controls="table" data-dt-idx="0" tabindex="0" id="table_previous">Previous</a><span><a class="paginate_button current" aria-controls="table" data-dt-idx="1" tabindex="0">1</a><a class="paginate_button " aria-controls="table" data-dt-idx="2" tabindex="0">2</a></span><a class="paginate_button next" aria-controls="table" data-dt-idx="3" tabindex="0" id="table_next">Next</a></div></div>
          </div>
    </div>
@endsection