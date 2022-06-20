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
        <input type="hidden" value="{{ $form->form_pembuatan_id }}" id="form_pembuatan_id"name="form_pembuatan_id">
        <div class="row">
            <div class="col-md-6">
                <label class="">NIK</label>
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
            {{-- <div class="col-md-6">
                <label>departemen</label>
                <select name="departemen_id" id="departemen_id" class="form-control" readonly>
                    <option value="{{ $form->departemen_id }}">{{ $form->departemen }}</option>
                </select>
            </div> --}}
            <div class="col-md-6">
                <label>Aplikasi</label>
                <select name="aplikasi_id[]" id="aplikasi_id"  class="form-control" readonly>
                    <option value="{{ $form->aplikasi_id}}"> {{ $form->aplikasi }}</option>
                </select>
            </div>
        </div>
            <div class="col-md-20">
                @if ($form->pass != null)
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                    <label>Password</label>
                    <input type="text" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                    @elseif (Auth::user()->role_id == 2)
                    <label>Password</label>
                    <input type="password" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                    @endif
                @else
                <input type="hidden" name="pass" id="pass[]" value="{{ $form->pass}}" class="form-control" readonly>
                @endif
            </div>
        </div>
        @if(Auth::user()->role_id != 3)
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
        @endif
    </div>
</form>

@stop
