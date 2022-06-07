@extends('adminlte::page')

@section('title', 'Detail')

@section('content_header')
<h1 class="m-0 text-dark">Detail</h1>
@stop

@section('content')
<form class="card" action="{{ route('approval.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <input type="hidden" value="{{ $form->user_id }}" name="user_id" id="user_id">
        <input type="hidden" value="{{ $form->form_aplikasi_id }}" id="form_aplikasi_id"name="form_aplikasi_id">
        <div class="row">
            <div class="col-md-6">
                <label class="">Username</label>
                <input type="text" value="{{ $form->username }}" id="username" name="username" class="form-control" readonly>
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
            <div class="col-md-6">
                <label>Store</label>
                <select  name="store_id" id="store_id" class="form-control" readonly>
                    <option value="{{ $form->store_id }}">{{ $form->nama_store }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Dapartemen</label>
                <select name="dapartemen_id" id="dapartemen_id" class="form-control" readonly>
                    <option value="{{ $form->dapartemen_id }}">{{ $form->dapartemen }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Aplikasi</label>
                <select name="aplikasi_id[]" id="aplikasi_id"  class="form-control" readonly>
                    <option value="{{ $form->aplikasi_id}}"> {{ $form->aplikasi }}</option>
                </select>
            </div>
        </div>
            <div class="col-md-20">
                @if ($form->pass != null)
                <label>Password</label>
                <select name="pass" id="pass[]"  class="form-control" readonly>
                    <option value="{{ $form->pass}}"> {{ $form->pass }}</option>
                </select>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div class="float-left">
                <button type="submit" class="btn btn-danger" name="disapprove" id="disapprove" value="disapprove">
                    <i class="fas fa-times"></i> DisApprove
                </button>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-success" name="approve" id="approve" value="approve">
                    <i class="fas fa-save"></i> Approve
                </button>
            </div>
        </div>
    </div>
</form>

@stop
