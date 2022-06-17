@extends('adminlte::page')

@section('title', 'Form')

{{-- @section('content_header')
<h1 class="m-0 text-dark"> <b> Form </b> </h1>
@stop --}}

@section('content')
<form class="card" action="{{ route('form.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-header">
        <h3 class="m-0 text-dark">
            <i class="fas fa-file"> </i>
            <b> Form </b>
        </h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
            <input type="hidden" value="{{ $user->name }}" name="name" id="name">
            <div class="col-md-4">
                <label>NIK</label>
                <input type="text" value="{{ $user->username }}" id="username"name="username" class="form-control form-control-sm" readonly>
            </div>
            <div class="col-md-4">
                <label>Region</label>
                <select name="region_id" id="region_id" class="form-control form-control-sm" readonly>
                    <option value="{{ $user->region_id }}">{{ $user->region->name }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Dapartemen</label>
                <select name="dapartemen_id" id="dapartemen_id" class="form-control form-control-sm" readonly>
                    <option value="{{ $user->dapartemen_id }}">{{ $user->dapartemen->dapartemen }}</option>
                </select>
            </div>
        </div>
        @if ($user->all_store == 'n')
        <div class="row">
            <div class="col-md-12">
                <label>Store</label>
                <select name="store_id" id="store_id" class="select2 form-control form-control-sm" placeholder="Select Store" required>
                    <option value="">Select Store</option>
                    @foreach ($stores as $store )
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <br>
        <label>Aplikasi</label>
        <div class="row">
            @foreach ( $app as $aplikasi)
                <div class="col-md-2">
                    <div class="">
                        <input class="form-check-inline" type="checkbox" name="aplikasi_id[]" id="aplikasi_id" value="{{ $aplikasi->id }}">
                        <label class="form-check-inline">{{ $aplikasi->aplikasi }}</label>
                    </div>
                </div>
                @if ($aplikasi->id == 1)
                    <div class="col-md-10">
                        <input type="text" class="form-control form-group" aria-label="Text input with checkbox" placeholder="ID" style="display: inline-flex" name="id_vega[]" id="id_vega" minlength="10" maxlength="10">
                        <input type="text" class="form-control form-group" aria-label="Text input with checkbox" placeholder="password" style="display: inline-flex" name="pass[]" id="pass" minlength="8" maxlength="8">
                    </div>
                @elseif ($aplikasi->id == 2)
                <div class="col-md-10">
                    <input type="text" class="form-control form-group" aria-label="Text input with checkbox" placeholder="password" style="display: inline-flex" name="pass[]" id="pass" minlength="6" maxlength="6">
                </div>
                @else
                <div class="col-md-10"><input type="hidden" dissable></div>
                @endif
            @endforeach
        </div>
        <br>
        <div class="float-left">
            <a href="{{ route('form.index') }}" class="btn btn-danger"><i class="fas fa-times"></i> Batal </a>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled = true; this.value = 'Submitting the form';">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
</form>

@stop
