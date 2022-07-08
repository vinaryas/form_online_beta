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
<form class="card" action="{{ route('form-pembuatan.index') }}" method="GET">
    {{ csrf_field() }}
    @if ( Auth::user()->status_pembuatan == 1 ||  Auth::user()->status_penghapusan == 1)

    @elseif (Auth::user()->role_id == config('setting_app.role_id.admin'))

    @else
    <div class="card-body">
        <a href="{{ route('form-pembuatan.create') }}" class="btn btn-info">
           <i class="fas fa-file"></i> Buat Form
       </a>
    </div>
    @endif
     <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>NIK</th>
                    <th>Region</th>
                    <th>Aplikasi</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($form as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->nik }}</td>
                        <td>{{ $detail->nama_region }}</td>
                        <td>{{ $detail->aplikasi }}</td>
                        <td> <a href="{{ route('form-pembuatan.status', $detail->form_pembuatan_id) }}"
                            class="btn btn-info btn-sm"> status <i class="fas fa-angle-right"> </i></a>
                         </td>
                        <td><a href="{{ route('form-pembuatan.detail', $detail->form_pembuatan_id) }}"
                            class="btn btn-info btn-sm"> detail <i class="fas fa-angle-right"> </i></a>
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
