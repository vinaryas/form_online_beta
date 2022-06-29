@extends('adminlte::page')

@section('title', 'History')

@section('content_header')
<h1 class="m-0 text-dark">History Approval</h1>
@stop

@section('content')
<form class="card" action="" method="GET">{{ csrf_field() }}
    <div class="card-header">
        <a href="{{ route('form-pembuatan.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>tgl Approved</th>
                    <th>Aplikasi</th>
                    <th>NIK</th>
                    <th>Approved by</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($log as $detail)
                    <tr>
                        <td>{{ $detail ->created_at }}</td>
                        <td>{{ $detail ->aplikasi }}</td>
                        <td>{{ $detail ->username}}</td>
                        <td>{{ $detail ->approver_name}}</td>
                        <th>{{ $detail ->status }}</th>
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
