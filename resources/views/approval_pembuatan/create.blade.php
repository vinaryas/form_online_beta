@extends('adminlte::page')

@section('title', 'Detail')

@section('content_header')
<h1 class="m-0 text-dark">Detail</h1>
@stop

@section('content')
<form class="card" action="{{ route('approval-pembuatan.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <input type="hidden" value="{{ $form->user_id }}" name="user_id" id="user_id">
        <input type="hidden" value="{{ $form->form_pembuatan_id }}" id="form_pembuatan_id"name="form_pembuatan_id">
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
                <select name="region_id" id="region_id" class="form-control" readonly>
                    <option value="{{ $form->region_id }}">{{ $form->nama_region }}</option>
                </select>
            </div>
            @if ($form->store_id != null)
                <div class="col-md-6">
                    <label>Store</label>
                    <select  name="store_id" id="store_id" class="form-control" readonly>
                        <option value="{{ $form->store_id }}">{{ $form->nama_store }}</option>
                    </select>
                </div>
            @endif
            <div class="col-md-6">
                <label>Aplikasi</label>
                <select name="aplikasi_id[]" id="aplikasi_id"  class="form-control" readonly>
                    <option value="{{ $form->aplikasi_id}}"> {{ $form->aplikasi }}</option>
                </select>
            </div>
            <div class="col-md-6">
                @if ($form->pass != null)
                    @if (Auth::user()->role_id == config('setting_app.role_id.it') || Auth::user()->role_id == config('setting_app.role_id.admin'))
                        <label>Password</label>
                        <input type="text" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                    @elseif (Auth::user()->role_id == config('setting_app.role_id.aux'))
                        <label>Password</label>
                        <input type="password" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                    @endif
                @else
                    <input type="hidden" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                @endif
            </div>
        </div>
        <br>
        @if(Auth::user()->role_id != config('setting_app.role_id.admin'))
        <div class="float-left">
            <button type="submit" class="btn btn-danger" name="disapprove" id="disapprove" value="disapprove">
                <i class="fas fa-times"></i> DisApprove
            </button>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-success" name="approve" id="approve" value="approve" >
                <i class="fas fa-save"></i> Approve
            </button>
        </div>
        @endif
    </div>
</form>

@stop
