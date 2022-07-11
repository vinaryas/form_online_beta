@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
<h1 class="m-0 text-dark">User</h1>
@stop

@section('content')
<div class="card" method="GET">
    {{ csrf_field() }}
     <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>Name</th>
                    <th>NIK</th>
                    <th>Region</th>
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
                        <td> <a href="{{ route('management.edit', $detail->user_id) }}"
                            class="btn btn-info btn-sm"> Edit <i class="fas fa-angle-right"> </i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop

@section('js')
    <script>
        $(document).ready(function () {
            console.log('teast');
            $('#table').DataTable();
        });
    </script>
@stop

