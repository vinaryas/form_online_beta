@extends('adminlte::page')

@section('title', 'Rj Server')

@section('content_header')
<h1 class="m-0 text-dark">Rj Server</h1>
@stop

@section('content')
<form class="card" action="{{route('rj_server.status')}}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <div class="row">
            <input type="hidden" value="{{ $rj->id }}" id="id"name="id">
            <div class="col-lg-6 col-6">
                <label> Name </label>
                <input type="text" value="{{ $rj->nama }}" id="name"name="name" class="form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label> NIK </label>
                <input type="text" value="{{ $rj->cashnum }}" id="nik"name="nik" class="form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label> Store </label>
                <input type="text" value="{{ $rj->nama_store }}"  name="store" id="store" class="select2 form-control" readonly>
                <input type="hidden" value="{{ $rj->store_id }}"  name="store_id" id="store_id">
            </div>
            <div class="col-lg-6 col-6">
                <label>Status</label>
                <input type="text" value="{{ $rj->status }}" class="form-control" maxlength="10" readonly>
            </div>
        </div>
    </div>
    <div class="card-body">
    <a href="{{ route('rj_server.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali </a>
        <div class="float-right">
            <button type="submit" class="btn btn-danger" name="inactive" id="inactive">
                <i class="fas fa-user-times"></i> Inactive
            </button>
            <button type="submit" class="btn btn-success" name="active" id="active">
                <i class="fas fa-user-check"></i> Active
            </button>
        </div>
    </div>
</form>

@stop
