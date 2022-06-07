@extends('adminlte::page')

@section('title', 'Approval')

@section('content_header')
<h1 class="m-0 text-dark">Approval</h1>
@stop

@section('content')
<form class="card" action="{{ route('approval.index') }}" method="GET">{{ csrf_field() }}
    <div class="card-body">
        <br>
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Dapartemen</th>
                    <th>Aplikasi</th>
                    <th>Approve</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formAplikasi as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->username }}</td>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->dapartemen }}</td>
                        <td>{{ $detail->aplikasi }}</td>
                        <td><a href="{{ route('approval.create', $detail->form_aplikasi_id) }}"
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
