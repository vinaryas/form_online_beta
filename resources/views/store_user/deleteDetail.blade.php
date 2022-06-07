@extends('adminlte::page')

@section('title', 'Store')

@section('content_header')
<h1 class="m-0 text-dark">Store</h1>
@stop

@section('content')
<form class="card" action="{{ route('store.delete') }}" method="POST">
    {{ csrf_field() }}
    <div class='card-header'>
        <input type="hidden" value="{{ $data->user_id }}" id="user_id" name="user_id" class="form-control" >
        <label>Name</label>
        <input type="text" value="{{ $data->user_name }}" id="user_name" name="user_name" class="form-control" readonly>
        <label>Store</label>
        <select name="store_id" id="store_id" class="form-control" readonly>
            <option value="{{ $data->store_id }}">{{ $data->store_name }}</option>
        </select>
    </div>
    <div class="card-footer">
        <a href="{{ route('store.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Batal </a>
        <div class="float-right">
            <button type="submit" class="btn btn-danger" id="delete" name="delete">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>
</form>

@stop
