@extends('adminlte::page')

@section('title', 'Approval')

@section('content_header')
<h1 class="m-0 text-dark">Approval</h1>
@stop

@section('content')
<form class="card" action="{{ route('approval-pembuatan.index') }}" method="GET">{{ csrf_field() }}
    <div class="card-body">
        <br>
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>NIK</th>
                    <th>Created By</th>
                    <th>Store Tujuan</th>
                    <th>Aplikasi</th>
                    <th>Approve</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($form as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->nik }}</td>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->nama_store }}</td>
                        <td>{{ $detail->aplikasi }}</td>
                        <td><a href="{{ route('approval-pembuatan.create', $detail->form_pembuatan_id) }}"
                            class="btn btn-info btn-sm"> Detail <i class="fas fa-angle-right"></i>
                        </a></td>
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
