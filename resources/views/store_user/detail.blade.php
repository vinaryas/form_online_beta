@extends('adminlte::page')

@section('title', 'Store')

@section('content_header')
<h1 class="m-0 text-dark">Store</h1>
@stop

@section('content')
<form class="card" action=" " method="GET">
    {{ csrf_field() }}
    <div class="card-header">
        <div class="float-left">
            <a href="{{ route('store.index') }}" class="btn btn-primary"><i class="fas fa-angle-left"></i> kembali </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th> Store Id </th>
                    <th> Store Name </th>
                    <th> Delete </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $detail)
                    <tr>
                        <td>{{ $detail->store_id }}</td>
                        <td>{{ $detail->store_name}}</td>
                        <td>
                            <a href="{{ route('store.deleteDetail', $detail->store_id)}}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete </a>
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
            console.log('toast');
            $('#table').DataTable();
        });
    </script>
@stop

