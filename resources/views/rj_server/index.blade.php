@extends('adminlte::page')

@section('title', 'Rj Server')

@section('content_header')
<h1 class="m-0 text-dark">Rj Server</h1>
@stop

@section('content')
<form class="card" action="{{ route('rj_server.index') }}" method="GET">{{ csrf_field() }}
    <div class="card-body">
        <br>
        <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>cashnum</th>
                    <th>Name</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rj as $detail)
                    <tr>
                        <td>{{ $detail->cashnum }}</td>
                        <td>{{ $detail->nama }}</td>
                        <td>{{ $detail->nama_store }}</td>
                        <td>{{ $detail->status }}</td>
                        <td><a href="{{ route('rj_server.detail', $detail->id) }}"
                            class="btn btn-info btn-sm"> Ubah Status <i class="fas fa-angle-right"></i>
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
