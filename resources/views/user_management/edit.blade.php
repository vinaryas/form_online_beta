@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
<h1 class="m-0 text-dark">User Management</h1>
@stop

@section('content')
<form class="card" action="{{route('management.update')}}" method="POST">
    {{ csrf_field() }}
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6 col-6">
                <label> Name </label>
                <input type="text" value="{{ $users->name }}" id="name"name="name" class="form-control">
            </div>
            <div class="col-lg-6 col-6">
                <label>NIK</label>
                <input type="text" value="{{ $users->id }}" id="username"name="username" class="form-control ">
            </div>
            <div class="col-lg-12 col-12">
                <label>Region</label>
                <select name="region_id" id="region_id" class="select2 form-control">
                    @foreach ($regions as $region)
                    <option value="{{ $region->id }}"  {{$users->region_id == $region->id ? 'selected' : '' }}  >{{ $region->name }}</option>
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
