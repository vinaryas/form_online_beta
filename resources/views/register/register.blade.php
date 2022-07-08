@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('title', 'Register')

@section('auth_header')
<h1 class="m-0 text-dark">Registration</h1>
@stop

@section('auth_body')
    <form action="{{ route('user.sync') }}" method="post">
        {{ csrf_field() }}
        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-info') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ 'login' }}">
            {{ __('Login') }}
        </a>
    </p>
@stop

