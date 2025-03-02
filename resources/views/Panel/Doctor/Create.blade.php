@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">افزودن پزشک جدید</h3>
                    </div>

                    <form action="{{ route('Doctor.Store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">نام:</label>
                                <div class="col-sm-9">
                                    <input name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                        id="name" value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="speciality_id" class="col-sm-3 col-form-label">تخصص:</label>
                                <div class="col-sm-9">
                                    <select name="speciality_id" class="form-control form-control-lg @error('speciality_id') is-invalid @enderror" 
                                        id="speciality_id" required>
                                        <option value="">انتخاب تخصص</option>
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality->id }}" {{ old('speciality_id') == $speciality->id ? 'selected' : '' }}>
                                                {{ $speciality->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="national_code" class="col-sm-3 col-form-label">کد ملی:</label>
                                <div class="col-sm-9">
                                    <input name="national_code" type="text" class="form-control form-control-lg @error('national_code') is-invalid @enderror"
                                        id="national_code" value="{{ old('national_code') }}" required />
                                    @error('national_code')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="medical_number" class="col-sm-3 col-form-label">شماره نظام پزشکی:</label>
                                <div class="col-sm-9">
                                    <input name="medical_number" type="text" class="form-control form-control-lg @error('medical_number') is-invalid @enderror"
                                        id="medical_number" value="{{ old('medical_number') }}" required />
                                    @error('medical_number')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="mobile" class="col-sm-3 col-form-label">شماره موبایل:</label>
                                <div class="col-sm-9">
                                    <input name="mobile" type="text" class="form-control form-control-lg @error('mobile') is-invalid @enderror"
                                        id="mobile" value="{{ old('mobile') }}" required />
                                    @error('mobile')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password" class="col-sm-3 col-form-label">رمز عبور:</label>
                                <div class="col-sm-9">
                                    <input name="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        id="password" required />
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="status" class="col-sm-3 col-form-label">وضعیت:</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control form-control-lg @error('status') is-invalid @enderror" 
                                        id="status" required>
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>غیرفعال</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">ثبت پزشک</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
