@extends('index')
@section('title', 'Lorem ipsum dolor sit amet consectetur.')
    
@section('content')
    
<table class="table">
    <thead  style="background-color: #6777ef !important;">
      <tr class="text-center">
        <th class="text-white" scope="col">#</th>
        <th class="text-white" scope="col">First</th>
        <th class="text-white" scope="col">Last</th>
        <th class="text-white" scope="col">Handle</th>
      </tr>
    </thead>
    <tbody class="table-group-divider text-center">
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      {{-- <tr>
        <th scope="row">3</th>
        <td colspan="2">Larry the Bird</td>
        <td>@twitter</td>
      </tr> --}}
    </tbody>
  </table>

@endsection