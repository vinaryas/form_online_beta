@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
<h1 class="m-0 text-dark">User</h1>
@stop

@section('content')
<div class="card" >
    <form action="{{ route('api_user.download') }}" method="POST">
        {{ csrf_field() }}
        <div class="card-body">
            <div class="float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
            <table class="table table-bordered table-striped" id="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>NIK</th>
                        <th>Region</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users['data'] as $detail)
                        <tr>
                            <td>{{ $detail['name'] }}</td>
                            <td>{{ $detail['id'] }}</td>
                            <td>{{ $detail['region_id'] }}</td>
                            <td>{{ $detail['role_id'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
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
