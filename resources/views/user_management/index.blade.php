@extends('adminlte::page')

@section('title', 'Form')

@section('content_header')
<h1 class="m-0 text-dark">Form</h1>
@stop

@section('content')
<form class="card" action="{{ route('form.index') }}" method="GET">
    {{ csrf_field() }}
     <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>Name</th>
                    <th>NIK</th>
                    <th>Region</th>
                    <th>Dapartemen</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->username }}</td>
                        <td>{{ $detail->region_name }}</td>
                        <td>{{ $detail->dapartemen }}</td>
                        <td> <a href="{{ route('management.edit', $detail->user_id) }}"
                            class="btn btn-info btn-sm"> detail <i class="fas fa-angle-right"> </i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>

@stop

@section('js')
    <script>
        $(document).ready(function () {
            console.log('teast');
            $('#table').DataTable();
        });
    </script>
@stop
