@extends('adminlte::page')

@section('title', 'Form')

@section('content')
<form class="card" action="{{ route('form-penghapusan.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <h3 class="m-0 text-dark">
            <i class="fas fa-file"> </i>
            <b> Form Penghapusan </b>
        </h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <input type="hidden" name="user_id" id="user_id" value="{{ $users->user_id }}">
            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $users->name }}" readonly>
            </div>
            <div class="col-md-6">
                <label>NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" value="{{ $users->username }}" readonly>
            </div>
            <div class="col-md-6">
                <label>Store</label>
                <select name="store_id" id="store_id" class="form-control" readonly>
                    <option value="{{ $users->store_id }}">{{ $users->store }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Alasan Penghapusan</label>
                <select name="alasan_id" id="alasan_id" class="select2 form-control" required>
                    <option > </option>
                    @foreach ($alasan as $detail)
                    <option value="{{ $detail->id }}">{{ $detail->alasan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            @foreach ( $app as $aplikasi)
            <input type="hidden" value="{{ $aplikasi->id }}" name="aplikasi_id[]" id="aplikasi_id">
            @endforeach
        </div>
    </div>
    <div  class="card-body">
        <div class="float-left">
            <a href="{{ route('form-penghapusan.index') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> Batal </a>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-danger" onclick="this.form.submit(); this.disabled = true; this.value = 'Submitting the form';">
                <i class="fas fa-save"></i> Ajukan Penghapusan
            </button>
        </div>
    </div>
</form>

@stop
