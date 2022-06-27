@extends('adminlte::page')

@section('title', 'Detail')

@section('content_header')
<h1 class="m-0 text-dark">Detail</h1>
@stop

@section('content')
<form class="card" action="{{ route('back_register.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>NIK</label>
                <input type="text" id="username" name="username" class="form-control" maxlength="9" required>
            </div>
            <div class="col-md-6">
                <label>Region</label>
                <select name="region_id" id="region_id" class="select2 form-control" required>
                    <option>  </option>
                    @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Role</label>
                <select name="role_id" id="role_id" class="select2 form-control" required>
                    <option>  </option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label>Password</label>
                <input type="text" id="password" name="password" class="form-control" maxlength="5" required>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="float-left">
            <a href="{{ route('back_register.index') }}" class="btn btn-info"><i class="fas fa-times"></i> Batal </a>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-success" name="approve" id="approve" value="approve" >
                <i class="fas fa-save"></i> register
            </button>
        </div>
    </div>
</form>

@stop
