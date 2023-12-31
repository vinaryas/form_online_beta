@extends('adminlte::page')

@section('title', 'Detail')

@section('content_header')
<h1 class="m-0 text-dark">Detail</h1>
@stop

@section('content')
<form class="card" method="GET">
    {{ csrf_field() }}
    <div class="card-body">
        <a href="{{ route('form-pembuatan.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label class="">NIK</label>
                <input type="text" value="{{ $form->nik }}" id="nik" name="nik" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label class="">Name</label>
                <input type="text" value="{{ $form->name }}" id="name" name="name" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Region</label>
                <input type="text"value="{{ $form->nama_region }}" name="region_id" id="region_id" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Store</label>
                <input type="text"value="{{ $form->nama_store }}" name="store_id" id="store_id" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Aplikasi</label>
                <input type="text"value=" {{ $form->aplikasi }}" name="aplikasi_id[]" id="aplikasi_id" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                @if ($form->pass != null)
                    <label>Password</label>
                    <input type="text" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                @endif
            </div>
        </div>
    </div>
</form>

@stop
