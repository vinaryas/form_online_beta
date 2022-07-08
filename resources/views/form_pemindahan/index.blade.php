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
<div class="card"  method="GET">
    {{ csrf_field() }}
    @if ( Auth::user()->status_pembuatan == 1 ||  Auth::user()->status_penghapusan == 1)

    @elseif (Auth::user()->role_id == config('setting_app.role_id.admin'))

    @else
    <div class="card-body">
        <a href="{{ route('form-pemindahan.create') }}" class="btn btn-info">
           <i class="fas fa-file"></i> Buat Form
       </a>
    </div>
    @endif
     <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>Name</th>
                    <th>NIK</th>
                    <th>Region</th>
                    <th>Store Asal</th>
                    <th>Store Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($form as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->nik }}</td>
                        <td>{{ $detail->nama_region }}</td>
                        <td>{{ $detail->from_store_name }}</td>
                        <td>{{ $detail->to_store_name }}</td>
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
