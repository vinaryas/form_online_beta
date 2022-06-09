@extends('adminlte::page')

@section('title', 'Role User')

@section('content_header')
<h1 class="m-0 text-dark">Role User</h1>
@stop

@section('content')
<form class="card" action="{{route('management.update')}}" method="POST">
    {{ csrf_field() }}
    <div class="card-header">
        <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
        <div class="row">
            <div class="col-lg-6 col-6">
                <label> Name </label>
                <input type="text" value="{{ $user->name }}" id="name"name="name" class="form-control">
            </div>
            <div class="col-lg-6 col-6">
                <label>NIK</label>
                <input type="text" value="{{ $user->username }}" id="username"name="username" class="form-control ">
            </div>
            <div class="col-lg-6 col-6">
                <label>Region</label>
                <select name="region_id" id="region_id" class="select2 form-control">
                    @foreach ($regions as $region)
                    <option value="{{ $region->id }}"  {{$user->region_id == $region->id ? 'selected' : '' }}  >{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 col-6">
                <label>Dapartemen</label>
                <select name="dapartemen_id" id="dapartemen_id" class="select2 form-control">
                    @foreach ($dapartemens as $dapartemen)
                    <option value="{{ $dapartemen->id }}"   {{$user->dapartemen_id == $dapartemen->id ? 'selected' : '' }} >{{ $dapartemen->dapartemen }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer">
    <a href="{{ route('management.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali </a>
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
