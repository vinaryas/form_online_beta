@extends('adminlte::page')

@section('title', 'Store')

@section('content_header')
<h1 class="m-0 text-dark">Store</h1>
@stop

@section('content')
<form class="card" action="#" method="GET">
    {{ csrf_field() }}
    <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th> NIK </th>
                    <th> Name </th>
                    <th> Region </th>
                    <th> Role </th>
                    <th> Store </th>
                    <th> Select Store </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $detail)
                    <tr>
                        <td>{{ $detail->username }}</td>
                        <td>{{ $detail->name}}</td>
                        <td>{{ $detail->region_name }}</td>
                        <td>{{ $detail->display_name }}
                        <td> <a href="{{ route('store.detail', $detail->user_id) }}" class="btn btn-info btn-sm"> Detail <i class="fas fa-angle-right"></i>  </a> </td>
                        <td> <a href="{{ route('store.create', $detail->user_id) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Toko </a> </td>
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
            console.log('toast');
            $('#table').DataTable();
        });
    </script>
@stop

