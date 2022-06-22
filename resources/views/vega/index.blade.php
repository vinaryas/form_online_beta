@extends('adminlte::page')

@section('title', 'vega')

@section('content_header')
<h1 class="m-0 text-dark">vega</h1>
@stop

@section('content')
<form class="card" action="{{ route('vega.index') }}" method="GET">{{ csrf_field() }}
    <div class="card-body">
        <br>
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Waktu Pembuatan</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Store</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vega as $detail)
                    <tr>
                        <td>{{ $detail->created_at }}</td>
                        <td>{{ $detail->nik }}</td>
                        <td>{{ $detail->name }}</td>
                        <td>{{ $detail->nama_store }}</td>
                        <td><a href="{{ route('vega.edit', $detail->form_pembuatan_id) }}"
                            class="btn btn-info btn-sm"> Edit <i class="fas fa-angle-right"></i>
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
