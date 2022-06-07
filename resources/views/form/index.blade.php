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

@elseif (Auth::user()->role_id == 1)
<div class="jumbotron">
    <div class="col col-md-12">
        <h1 class="text-danger font-weight-bolder">Sight!</h1>
        <h1 class="text-danger font-weight-bolder">IT need no form!</h1>
    </div>
</div>

@else
<form class="card" action="{{ route('form.index') }}" method="GET">
    {{ csrf_field() }}
     <div class="card-header">
         <a href="{{ route('form.create') }}" class="btn btn-primary">
            <i class="fas fa-file"></i> Buat Form
        </a>
     </div>
     <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>NIK</th>
                    <th>Region</th>
                    <th>Dapartemen</th>
                    <th>Aplikasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formAplikasi as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->username }}</td>
                        <td>{{ $detail->nama_region }}</td>
                        <td>{{ $detail->dapartemen }}</td>
                        <td>{{ $detail->aplikasi }}</td>
                        <td> <a href="{{ route('form.status', $detail->form_aplikasi_id) }}"
                            class="btn btn-info btn-sm"> status <i class="fas fa-angle-right"> </i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
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
