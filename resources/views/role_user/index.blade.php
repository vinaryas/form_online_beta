@extends('adminlte::page')

@section('title', 'Role User')

@section('content_header')
<h1 class="m-0 text-dark">Role User</h1>
@stop

@section('content')
<form class="card" action="{{ route('role.index') }}" method="GET">
    {{ csrf_field() }}
    <div class="card-body">
        <br>
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Region</th>
                    <th>Store</th>
                    <th>Role selected</th>
                    <th>Role select</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->username }}</td>
                        <td>{{ $detail->name}}</td>
                        <td>{{ $detail->region_name }}</td>
                        <td>{{ $detail->store }}</td>
                        <td>{{ $detail->display_name }}</td>
                        <td> <a href="{{ route('role.create', $detail->user_id) }}" class="btn btn-info btn-sm"> Select Role <i class="fas fa-angle-right"></i>  </a> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
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


