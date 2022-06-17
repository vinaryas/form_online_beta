@extends('adminlte::page')

@section('title', 'Store')

@section('content_header')
<h1 class="m-0 text-dark">Store</h1>
@stop

@section('content')
<form class="card" action="{{ route('store.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <div class="form-group row">
            <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
            <input type="hidden" value="{{ $user->name }}" name="name" id="name">
            <div class="col-md-4">
                <label>NIK</label>
                <input type="text" value="{{ $user->username }}" id="username"name="username" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Region</label>
                <select name="region_id" id="region_id" class="form-control" readonly>
                    <option value="{{ $user->region_id }}">{{ $user->region->name }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Dapartemen</label>
                <select name="dapartemen_id" id="dapartemen_id" class="form-control" readonly>
                    <option value="{{ $user->dapartemen_id }}">{{ $user->dapartemen->dapartemen }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <label>Store</label>
            <select name="store_id" id="store_id" class="select2 form-control" placeholder="Select Store" required>
                <option value="">Select Store</option>
                @foreach ($stores as $store )
                <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
            <div class="float-left">
                <a href="{{ route('store.index') }}" class="btn btn-danger"><i class="fas fa-times"></i> Batal </a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
    </div>
</form>

@stop
