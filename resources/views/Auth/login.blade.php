@extends('Auth.layouts.Master')

@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="../index2.html"><b>admin</b>LTE</a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">فرم ورود</p>

        @if(session('error'))
            <div class="alert alert-danger text-center mb-3">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('Login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                    placeholder="شماره تماس" value="{{ old('phone') }}" />
                <div class="input-group-text"><span class="bi bi-telephone"></span></div>
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="رمز عبور" />
                <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">ورود</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
