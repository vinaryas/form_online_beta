@extends('adminlte::page')

@section('title', 'Detail')

@section('content_header')
<h1 class="m-0 text-dark">Detail</h1>
@stop

@section('content')
<form class="card" action="{{ route('approval-pembuatan.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">
        <input type="hidden" value="{{ $form->created_by }}" name="user_id" id="user_id">
        <input type="hidden" value="{{ $form->form_penghapusan_id }}" id="form_penghapusan_id"name="form_penghapusan_id">
        <div class="row">
            <div class="col-md-6">
                <label class="">NIK</label>
                <input type="text" value="{{ $form->nik }}" id="nik" name="nik" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Region</label>
                <select name="region_id" id="region_id" class="form-control" readonly>
                    <option value="{{ $form->region_id }}">{{ $form->nama_region }}</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="">Name</label>
                <input type="text" value="{{ $form->name }}" id="name" name="name" class="form-control" readonly>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nama Yang DiHapus</th>
                        <th>Nik Yang DIhapus</th>
                        <th>Store Asal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $detailPenghapusan->name}}</td>
                        <td>{{ $detailPenghapusan->deleted_nik }}</td>
                        <td>{{ $detailPenghapusan->nama_store }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        @if(Auth::user()->role_id != config('setting_app.role_id.admin'))
        <div class="float-left">
            <button type="submit" class="btn btn-danger" name="disapprove" id="disapprove" value="disapprove">
                <i class="fas fa-times"></i> DisApprove
            </button>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-success" name="approve" id="approve" value="approve" >
                <i class="fas fa-save"></i> Approve
            </button>
        </div>
        @endif
    </div>
</form>

@stop
