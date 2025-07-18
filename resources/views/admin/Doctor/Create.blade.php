@extends('admin.layouts.master')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.25rem;
            direction: rtl;
        }

        .select2-selection__choice {
            background-color: #0d6efd !important;
            border: none !important;
            color: #fff !important;
            padding: 0 8px !important;
            margin-left: 4px !important;
            font-size: 0.85rem;
        }

        .select2-container--default .select2-results>.select2-results__options {
            text-align: right;
        }
    </style>

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title mb-0">افزودن پزشک جدید</h5>
                    </div>

                    <form action="{{ route('Doctor.Store') }}" method="POST" class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label small">نام:</label>
                                    <input name="name" type="text"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">تخصص:</label>
                                    <select name="speciality_id"
                                        class="form-control form-control-sm @error('speciality_id') is-invalid @enderror"
                                        required>
                                        <option value="">انتخاب تخصص</option>
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality->id }}"
                                                {{ old('speciality_id') == $speciality->id ? 'selected' : '' }}>
                                                {{ $speciality->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">کد ملی:</label>
                                    <input name="national_code" type="text"
                                        class="form-control form-control-sm @error('national_code') is-invalid @enderror"
                                        value="{{ old('national_code') }}" required />
                                    @error('national_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">شماره نظام پزشکی:</label>
                                    <input name="medical_number" type="text"
                                        class="form-control form-control-sm @error('medical_number') is-invalid @enderror"
                                        value="{{ old('medical_number') }}" required />
                                    @error('medical_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">شماره موبایل:</label>
                                    <input name="mobile" type="text"
                                        class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                        value="{{ old('mobile') }}" required />
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ✅ Select2 برای نقش‌ها -->
                                <div class="col-6">
                                    <label class="form-label small">نقش‌های پزشک:</label>
                                    <select name="Doctor_roles[]"
                                        class="form-control form-control-sm select2-multiple @error('Doctor_roles') is-invalid @enderror"
                                        multiple="multiple" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ in_array($role->id, old('Doctor_roles', [])) ? 'selected' : '' }}>
                                                {{ $role->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Doctor_roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-6">
                                    <label class="form-label small">وضعیت:</label>
                                    <select name="status"
                                        class="form-control form-control-sm @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>فعال
                                        </option>
                                        <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>غیرفعال
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">رمز عبور:</label>
                                    <input name="password" type="password"
                                        class="form-control form-control-sm @error('password') is-invalid @enderror"
                                        required />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">تکرار رمز عبور:</label>
                                    <input name="password_confirmation" type="password" class="form-control form-control-sm"
                                        required />
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-sm px-4">ثبت پزشک</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/fa.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: "نقش‌های پزشک را انتخاب کنید",
                language: "fa",
                dir: "rtl",
                width: '100%',
                allowClear: true,
                closeOnSelect: false
            });
        });
    </script>
@endsection
