@extends('adminlte::page')

@section('title', 'Form')

@section('content')
<form class="card" action="{{ route('form-pemindahan.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-header">
        <h3 class="m-0 text-dark">
            <i class="fas fa-file"> </i>
            <b> Form Pemindahan </b>
        </h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
            <input type="hidden" value="{{ $user->username }}" name="name" id="name">
            <div class="col-md-6">
                <label>NIK</label>
                <input type="text" value="{{ $user->username }}" id="nik"name="nik" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Region</label>
                <select name="region_id" id="region_id" class="form-control" readonly>
                    <option value="{{ $user->region_id }}">{{ $user->region->name }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Store Asal</label>
                <select name="store_id_asal" id="store_id_asal" class="form-control" readonly>
                    <option value="{{ $user->store_id }}">{{ $user->store->name }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Store Tujuan</label>
                <select name="store_id_tujuan" id="store_id_tujuan" class="select2 form-control">
                    <option> </option>
                    @foreach ( $stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
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
                @if ($aplikasi->id == config('setting_app.aplikasi_id.vega'))
                    <div class="col-md-10">
                        <input type="text" class="form-control form-group" aria-label="Text input with checkbox" placeholder="ID" style="display: inline-flex" name="id_vega[]" id="id_vega" minlength="10" maxlength="10">
                        <input type="text" class="form-control form-group" aria-label="Text input with checkbox" placeholder="password" style="display: inline-flex" name="pass[]" id="pass" minlength="8" maxlength="8">
                    </div>
                @elseif ($aplikasi->id == config('setting_app.aplikasi_id.rjserver'))
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
            <a href="{{ route('form-pembuatan.index') }}" class="btn btn-danger"><i class="fas fa-times"></i> Batal </a>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled = true; this.value = 'Submitting the form';">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
</form>

@stop
