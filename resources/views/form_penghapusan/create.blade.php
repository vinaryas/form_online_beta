@extends('adminlte::page')

@section('title', 'Form')

@section('content')
<form class="card" action="" method="POST">
    {{ csrf_field() }}
    <div class="card-header">
        <h3 class="m-0 text-dark">
            <i class="fas fa-file"> </i>
            <b> Form Penghapusan </b>
        </h3>
    </div>
    <div  class="card-body">
        <div class="float-left">
            <a href="{{ route('form-penghapusan.index') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> Batal </a>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled = true; this.value = 'Submitting the form';">
                <i class="fas fa-save"></i> Ajukan Penghapusan
            </button>
        </div>
    </div>
    <input type="hidden" value="{{ $user->user_id }}" name="user_id" id="user_id">
    <div class="card-footer">
        <div class="form-group row">
            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" value="{{ $user->name }}" name="name" id="name" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>NIK</label>
                <input type="text" value="{{ $user->username }}" id="nik"name="nik" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Region</label>
                <select name="region_id" id="region_id" class="form-control" readonly>
                    <option value="{{ $user->region_id }}">{{ $user->region_name }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Store</label>
                <select name="store_id" id="store_id" class="form-control" readonly>
                    <option value="{{ $user->store_id }}">{{ $user->store }}</option>
                </select>
            </div>
        </div>
        {{-- <table class="table table-bordered table-striped" id="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th>ID</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $detail)
                    <tr>
                        <td>{{ $detail-> }}</td>
                        <td>{{ $detail-> }}</td>
                        <td><input type="password" value="{{ $detail->username }}" class='form-control'></td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
</form>

@stop
