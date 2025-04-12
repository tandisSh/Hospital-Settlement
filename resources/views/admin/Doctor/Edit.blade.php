@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header bg-warning text-black text-center">
                        <h5 class="card-title mb-0">ویرایش اطلاعات پزشک</h5>
                    </div>

                    <form action="{{ route('Doctor.Update', $doctor->id) }}" method="POST" class="needs-validation p-3"
                        novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small">نام:</label>
                                    <input name="name" type="text"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name', $doctor->name) }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label small">تخصص:</label>
                                    <select name="speciality_id"
                                        class="form-control form-control-sm @error('speciality_id') is-invalid @enderror"
                                        required>
                                        <option value="">انتخاب تخصص</option>
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality->id }}"
                                                {{ old('speciality_id', $doctor->speciality_id) == $speciality->id ? 'selected' : '' }}>
                                                {{ $speciality->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">کد ملی:</label>
                                    <input name="national_code" type="text"
                                        class="form-control form-control-sm @error('national_code') is-invalid @enderror"
                                        value="{{ old('national_code', $doctor->national_code) }}" required />
                                    @error('national_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">شماره نظام پزشکی:</label>
                                    <input name="medical_number" type="text"
                                        class="form-control form-control-sm @error('medical_number') is-invalid @enderror"
                                        value="{{ old('medical_number', $doctor->medical_number) }}" required />
                                    @error('medical_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">شماره موبایل:</label>
                                    <input name="mobile" type="text"
                                        class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                        value="{{ old('mobile', $doctor->mobile) }}" required />
                                    @error('mobile')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">نقش‌های پزشک:</label>
                                    <select name="Doctor_roles[]"
                                        class="form-control form-control-sm @error('roles') is-invalid @enderror"
                                        multiple="multiple" required id="doctor-roles">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">وضعیت:</label>
                                    <select name="status"
                                        class="form-control form-control-sm @error('status') is-invalid @enderror" required>
                                        <option value="1"
                                            {{ old('status', $doctor->status) == '1' ? 'selected' : '' }}>فعال</option>
                                        <option value="0"
                                            {{ old('status', $doctor->status) == '0' ? 'selected' : '' }}>غیرفعال</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning btn-sm px-4">ویرایش اطلاعات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#doctor-roles').select2({
                placeholder: "نقش‌های پزشک را انتخاب کنید",
                allowClear: true
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
