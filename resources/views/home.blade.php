@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@if(Auth::user()->role_id === null)

@else
<h1 class="m-0 text-dark">Dashboard</h1>
@endif
@stop

@section('content')
@if (Auth::user()->role_id === null)
<div class="jumbotron">
    <div class="row justify-content-center">
        <div class="col col-md-12">
            <div class="jumbotron">
                <h1 class="text-danger font-weight-bolder"> <b> Warning! </b> </h1>
                <h1 class="text-danger font-weight-bolder">Refer to your Admin to assign Role!</h1>
            </div>
        </div>
    </div>
</div>

@elseif (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
<div class="row">
    <div class="col-lg-12 col-6">
		<div class="small-box bg-info">
			<div class="inner text-center">
                <h3> {{ $countApproval }} </h3>
				<p> <b> Total Aplikasi Butuh Approval </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-invoice" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-12 col-6">
		<div class="small-box bg-info">
			<div class="inner text-center">
                <h3> {{ $countForm }} </h3>
				<p> <b> Total Form yang dibuat </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-invoice" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-6 col-6">
		<div class="small-box bg-success">
			<div class="inner text-center">
                <h3> {{ $countApproved }} </h3>
				<p> <b> Total Aplikasi yang dibuat ter-Approved </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-signature" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-6">
		<div class="small-box bg-danger">
			<div class="inner text-center">
                <h3> {{ $countDisapproved }} </h3>
				<p> <b> Total Aplikasi yang dibuat ter-DisApprove </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-contract" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>

@elseif (Auth::user()->role_id == 3)
<div class="row">
    <div class="col-lg-12 col-6">
		<div class="small-box bg-info">
			<div class="inner text-center">
                <h3> {{ $countApproval }} </h3>
				<p> <b> Total Aplikasi </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-invoice" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-12 col-6">
		<div class="small-box bg-info">
			<div class="inner text-center">
                <h3> {{ $countForm }} </h3>
				<p> <b> Total Form </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-invoice" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-6 col-6">
		<div class="small-box bg-success">
			<div class="inner text-center">
                <h3> {{ $countApproved }} </h3>
				<p> <b> Total Aplikasi ter-Approved </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-signature" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-6">
		<div class="small-box bg-danger">
			<div class="inner text-center">
                <h3> {{ $countDisapproved }} </h3>
				<p> <b> Total Aplikasi ter-DisApprove </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-contract" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>


@else
<div class="row">
    <div class="col-lg-12 col-6">
		<div class="small-box bg-info">
			<div class="inner text-center">
                <h3> {{ $countForm }} </h3>
				<p> <b> Total Form </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-invoice" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-lg-6 col-6">
		<div class="small-box bg-success">
			<div class="inner text-center">
                <h3> {{ $countApproved }} </h3>
				<p> <b> Total Aplikasi ter-Approved </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-signature" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-6">
		<div class="small-box bg-danger">
			<div class="inner text-center">
                <h3> {{ $countDisapproved }} </h3>
				<p> <b> Total Aplikasi ter-DisApprove </b> </p>
			</div>
			<div class="icon">
				<i class="fas fa-file-contract" style="color: rgba(255, 255, 255, 0.5);"></i>
			</div>
		</div>
	</div>
</div>
@endif

@stop

@section('css')
@stop

@section('js')
@stop
