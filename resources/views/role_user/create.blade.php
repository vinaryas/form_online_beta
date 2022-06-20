@extends('adminlte::page')

@section('title', 'Role User')

@section('content_header')
<h1 class="m-0 text-dark">Role User</h1>
@stop

@section('content')
<form class="card" action="{{route('role.update')}}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
        <div class="row">
            <div class="col-lg-6 col-6">
                <label>NIK</label>
                <input type="text" value="{{ $user->username }}" id="username" name="username" class="form-control " readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label> Name </label>
                <input type="text" value="{{ $user->name }}" id="name" name="name" class="form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label>Region</label>
                <input type="text" value="{{ $user->region->name }}" id="region_id" name="region_id" class="form-control" readonly>
            </div>
            <div class="col-lg-6 col-6">
                <label>Role</label>
                <select name="role_id" id="role_id" class="select2 form-control" required>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{$user->role_id == $role->id ? 'selected' : '' }}>{{ $role->display_name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div class="col-lg-6 col-6">
                <label>departemen</label>
                <select name="departemen_id" id="departemen_id" class="form-control" readonly>
                    <option value="{{ $user->departemen_id }}">{{ $user->departemen->departemen }}</option>
                </select>
            </div> --}}
        </div>
    </div>
    <div class="card-footer">
    <a href="{{ route('role.index') }}" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali </a>
        <div class="float-right">
            <button type="submit" class="btn btn-danger" name="delete" id="delete">
                <i class="fas fa-trash"></i> Delete Role
            </button>
            <button type="submit" class="btn btn-success" name="save" id="save">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
</form>

@stop
