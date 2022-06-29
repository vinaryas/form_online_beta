@extends('adminlte::page')

@section('title', 'Form')

@section('content_header')
@if(Auth::user()->role_id === null)

@else
<h1 class="m-0 text-dark">Form</h1>
@endif
@stop

@section('content')
@if (Auth::user()->role_id === null)
<div class="jumbotron">
    <div class="row justify-content-center">
        <div class="col col-md-12">
            <div class="jumbotron">
                <h1 class="text-danger font-weight-bolder">Warning!</h1>
                <h1 class="text-danger font-weight-bolder">Refer to your Admin to assign Role!</h1>
            </div>
        </div>
    </div>
</div>

@else
<div class="card" method="GET">
    {{ csrf_field() }}
     <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th> Nama </th>
                    <th >NI K</th>
                    <th> Region </th>
                    <th> Store </th>
                    <th> Ajukan Penghapusan </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($form as $detail)
                    <tr>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->username }}</td>
                        <td>{{ $detail->region_name }}</td>
                        <td>{{ $detail->store }}</td>
                        <td> <a href="{{ route('form-penghapusan.create', $detail->user_id) }}" class="btn btn-info">
                            <i class="fas fa-file"></i> Buat Form </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@stop

@section('js')
    <script>
        $(document).ready(function () {
            console.log('teast');
            $('#table').DataTable();
        });
    </script>
@stop
