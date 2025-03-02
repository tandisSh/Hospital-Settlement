@extends('Panel.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header bg-warning text-black text-center">
                        <h5 class="card-title mb-0">ویرایش پروفایل</h5>
                    </div>

                    <form action="{{route('updateProfile')}}" method="POST" class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small">نام:</label>
                                    <input name="name" type="text" class="form-control form-control-sm"
                                           value="{{ Auth::user()->name }}" required />
                                </div>
                                <div class="col-6">
                                    <label class="form-label small">ایمیل:</label>
                                    <input name="email" type="email" class="form-control form-control-sm"
                                           value="{{ Auth::user()->email }}" required />
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small">شماره تلفن:</label>
                                    <input name="phone" type="text" class="form-control form-control-sm"
                                           value="{{ Auth::user()->phone ?? '' }}" />
                                </div>
                            </div>

                            {{-- تغییر رمز عبور (اختیاری) --}}
                            <div class="border-top pt-3 mt-3">
                                <h6 class="text-center mb-3 text-muted">تغییر رمز عبور (اختیاری)</h6>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small">رمز عبور فعلی:</label>
                                        <input name="current_password" type="password" class="form-control form-control-sm" />
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">رمز عبور جدید:</label>
                                        <input name="new_password" type="password" class="form-control form-control-sm" />
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small">تکرار رمز عبور جدید:</label>
                                        <input name="new_password_confirmation" type="password" class="form-control form-control-sm" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning btn-sm px-4">بروزرسانی اطلاعات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
