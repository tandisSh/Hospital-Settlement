@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">افزودن پزشک جدید</h3>
                    </div>

                    <form action="{{ route('Doctor.Store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">نام:</label>
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                            id="name" value="{{ old('name') }}" required />
                                        @error('name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="speciality_id" class="form-label">تخصص:</label>
                                        <select name="speciality_id" class="form-control @error('speciality_id') is-invalid @enderror" 
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

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="national_code" class="form-label">کد ملی:</label>
                                        <input name="national_code" type="text" class="form-control @error('national_code') is-invalid @enderror"
                                            id="national_code" value="{{ old('national_code') }}" required />
                                        @error('national_code')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="medical_number" class="form-label">شماره نظام پزشکی:</label>
                                        <input name="medical_number" type="text" class="form-control @error('medical_number') is-invalid @enderror"
                                            id="medical_number" value="{{ old('medical_number') }}" required />
                                        @error('medical_number')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">شماره موبایل:</label>
                                        <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                            id="mobile" value="{{ old('mobile') }}" required />
                                        @error('mobile')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">وضعیت:</label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror" 
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

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">رمز عبور:</label>
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" required />
                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">تکرار رمز عبور:</label>
                                        <input name="password_confirmation" type="password" class="form-control"
                                            id="password_confirmation" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">ثبت پزشک</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
