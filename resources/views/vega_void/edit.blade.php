@extends('adminlte::page')

@section('title', 'vega')

@section('content_header')
<h1 class="m-0 text-dark">vega</h1>
@stop

@section('content')
<form class="card" action="{{route('vega.update')}}" method="POST">
    {{ csrf_field() }}
    <div class="card-header">
        <div class="row">
            <input type="hidden" value="{{ $vega->form_aplikasi_id }}" id="form_aplikasi_id"name="form_aplikasi_id" readonly>
            <div class="col-lg-6 col-6">
                <label> Name </label>
                <input type="text" value="{{ $vega->name }}" id="name"name="name" class="form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label>NIK</label>
                <input type="text" value="{{ $vega->username }}" id="username"name="username" class="form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label>Region</label>
                <input type="text" value="{{ $vega->nama_region }}" name="region_id" id="region_id" class="select2 form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label>Dapartemen</label>
                <input type="text" value="{{ $vega->dapartemen }}"  name="dapartemen_id" id="dapartemen_id" class="select2 form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label>ID Vega</label>
                <input type="text" value="{{ $vega->id_vega }}" id="id_vega" name="id_vega" class="form-control" maxlength="10">
            </div>
            <div class="col-lg-6 col-6">
                <label>Password</label>
                <input type="text" value="{{ $vega->pass }}" name="pass" id="pass" class="form-control" maxlength="8">
            </div>
        </div>
    </div>
    <div class="card-footer">
    <a href="{{ route('vega.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali </a>
        <div class="float-right">
            <button type="submit" class="btn btn-danger" name="delete" id="delete">
                <i class="fas fa-trash"></i> Delete
            </button>
            <button type="submit" class="btn btn-success" name="update" id="update">
                <i class="fas fa-save"></i> Update
            </button>
        </div>
    </div>
</form>

@stop
