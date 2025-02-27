@extends('Auth.layouts.Master')

@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="../index2.html"><b>Admin</b>LTE</a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">فرم ورود</p>
        <form action="{{route('Login')}}" method="post">
            @csrf
          <div class="input-group mb-3">
            <input name="phone" type="text" class="form-control" placeholder="شماره تماس" />
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
          </div>
          <div class="input-group mb-3">
            <input name="password" type="password" class="form-control" placeholder="رمز عبور" />
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
          </div>
          <div class="row">
            <div class="col-4">
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">ورود</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
