@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">ثبت کاربر جدید</h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('User.Store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">اسم:</label>
                                <div class="col-sm-9">
                                    <input name="name" type="text" class="form-control form-control-lg" id="name"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً نام خود را وارد کنید.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-3 col-form-label">ایمیل:</label>
                                <div class="col-sm-9">
                                    <input name="email" type="email" class="form-control form-control-lg" id="email"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً یک ایمیل معتبر وارد کنید.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="phone" class="col-sm-3 col-form-label">شماره تلفن:</label>
                                <div class="col-sm-9">
                                    <input name="phone" type="text" class="form-control form-control-lg" id="phone"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً شماره تلفن خود را وارد کنید.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-3 col-form-label">رمز عبور:</label>
                                <div class="col-sm-9">
                                    <input name="password" type="password" class="form-control form-control-lg"
                                        id="password" required />
                                    <div class="invalid-feedback">
                                        لطفاً رمز عبور خود را وارد کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">ثبت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
