@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

{{-- @php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif --}}
@section('title', 'Register')

@section('auth_header')
<h1 class="m-0 text-dark">Registration</h1>
@stop


@section('auth_body')
    <form action="{{ route('user.store') }}" method="post">
        {{ csrf_field() }}

        {{-- Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
            value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>

          {{-- UserName --}}
          <div class="input-group mb-3">
            <input type="text" name="username" id="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
            value="{{ old('username') }}" placeholder="NIK" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('username'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('username') }}</strong>
                </div>
            @endif
        </div>

          {{-- regions --}}
        <div class="input-group mb-3">
            <select class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" name="region_id" id="region_id"
            value="{{ old('region') }}" placeholder="region" autofocus>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('region'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('region') }}</strong>
                </div>
            @endif
        </div>

          {{-- dapartemens --}}
          <div class="input-group mb-3">
            <select class="form-control {{ $errors->has('dapartemen') ? 'is-invalid' : '' }}" name="dapartemen_id" id="dapartemen_id"
            value="{{ old('dapartemen') }}" placeholder="Dapartemen" autofocus>
                @foreach ($dapartemens as $dapartemen)
                    <option value="{{ $dapartemen->id }}">{{ $dapartemen->dapartemen }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('dapartemen'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('dapartemen') }}</strong>
                </div>
            @endif
        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="input-group mb-3">
            <label class="text-danger font-weight-bold">Password Selalu "12345"</label>
        </div>


        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="hidden" name="password" id="password" value="{{ 12345 }}">
                   {{-- class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   placeholder="{{ __('adminlte::adminlte.password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif --}}
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="hidden" name="password_confirmation" id="password_confirmation" value="{{ 12345 }}">
                   {{-- class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                   placeholder="{{ __('adminlte::adminlte.retype_password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
            @endif --}}
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
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

