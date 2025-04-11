@extends('admin.layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/persian-datepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header bg-warning text-black text-center">
                        <h5 class="card-title mb-0">ویرایش جراحی</h5>
                    </div>
                    @if ($errors->has('quota_error'))
                        <div class="alert alert-danger text-center">
                            {{ $errors->first('quota_error') }}
                        </div>
                    @endif
                    <form action="{{ route('surgery.update', ['id' => $surgery->id]) }}" method="POST"
                        class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small">نام بیمار:</label>
                                    <input name="patient_name" type="text"
                                        class="form-control form-control-sm @error('patient_name') is-invalid @enderror"
                                        value="{{ old('patient_name', $surgery->patient_name) }}" required />
                                    @error('patient_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label small">کد ملی بیمار:</label>
                                    <input name="patient_national_code" type="text"
                                        class="form-control form-control-sm @error('patient_national_code') is-invalid @enderror"
                                        value="{{ old('patient_national_code', $surgery->patient_national_code) }}"
                                        required />
                                    @error('patient_national_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">بیمه پایه:</label>
                                    <select name="basic_insurance_id"
                                        class="form-control form-control-sm @error('basic_insurance_id') is-invalid @enderror"
                                        required>
                                        <option value="">انتخاب بیمه پایه</option>
                                        @foreach ($insurances as $insurance)
                                            @if ($insurance->type == 'basic')
                                                <option value="{{ $insurance->id }}"
                                                    {{ old('basic_insurance_id', $surgery->basic_insurance_id) == $insurance->id ? 'selected' : '' }}>
                                                    {{ $insurance->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('basic_insurance_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">بیمه تکمیلی:</label>
                                    <select name="supp_insurance_id"
                                        class="form-control form-control-sm @error('supp_insurance_id') is-invalid @enderror">
                                        <option value="">انتخاب بیمه تکمیلی</option>
                                        @foreach ($insurances as $insurance)
                                            @if ($insurance->type == 'supplementary')
                                                <option value="{{ $insurance->id }}"
                                                    {{ old('supp_insurance_id', $surgery->supp_insurance_id) == $insurance->id ? 'selected' : '' }}>
                                                    {{ $insurance->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('supp_insurance_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">شماره پرونده:</label>
                                    <input name="document_number" type="number"
                                        class="form-control form-control-sm @error('document_number') is-invalid @enderror"
                                        value="{{ old('document_number', $surgery->document_number) }}" required />
                                    @error('document_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label small">توضیحات:</label>
                                    <textarea name="description" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                        rows="3">{{ old('description', $surgery->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">پزشک جراح:</label>
                                    <select name="surgeon_doctor_id"
                                        class="form-control form-control-sm @error('surgeon_doctor_id') is-invalid @enderror"
                                        required>
                                        <option value="">انتخاب پزشک جراح</option>
                                        @foreach ($surgeons as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('surgeon_doctor_id', $surgery->doctors->where('pivot.doctor_role_id', 2)->first()?->id) == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('surgeon_doctor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">پزشک بیهوشی:</label>
                                    <select name="anesthesiologist_doctor_id"
                                        class="form-control form-control-sm @error('anesthesiologist_doctor_id') is-invalid @enderror"
                                        required>
                                        <option value="">انتخاب پزشک بیهوشی</option>
                                        @foreach ($anesthesiologists as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('anesthesiologist_doctor_id', $surgery->doctors->where('pivot.doctor_role_id', 1)->first()?->id) == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('anesthesiologist_doctor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label small">پزشک مشاور:</label>
                                    <select name="consultant_doctor_id"
                                        class="form-control form-control-sm @error('consultant_doctor_id') is-invalid @enderror">
                                        <option value="">انتخاب پزشک مشاور</option>
                                        @foreach ($consultants as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('consultant_doctor_id', $surgery->doctors->where('pivot.doctor_role_id', 3)->first()?->id) == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('consultant_doctor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label small">نوع جراحی:</label>
                                    <select name="surgery_types[]"
                                        class="form-control form-control-sm select2 @error('surgery_types') is-invalid @enderror"
                                        multiple="multiple" required>
                                        @foreach ($operations as $type)
                                            <option value="{{ $type->id }}" data-price="{{ $type->price }}"
                                                {{ in_array($type->id, old('surgery_types', $surgery->operations->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $type->name }} ({{ number_format($type->price) }} تومان)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('surgery_types')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('surgery_types.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">تاریخ جراحی:</label>
                                    <input name="surgeried_at" type="date"
                                        class="form-control form-control-sm @error('surgeried_at') is-invalid @enderror"
                                        value="{{ old('surgeried_at', $surgery->surgeried_at) }}" required />
                                    @error('surgeried_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">تاریخ ترخیص:</label>
                                    <input name="released_at" type="date"
                                        class="form-control form-control-sm @error('released_at') is-invalid @enderror"
                                        value="{{ old('released_at', $surgery->released_at) }}" required />
                                    @error('released_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning btn-sm px-4">ویرایش جراحی</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/persian-datepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/persian-datepicker/persian-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'نوع عمل‌های جراحی را انتخاب کنید',
                allowClear: true,
                dir: 'rtl'
            });
        });

        $('.persian-date').persianDatepicker({
            format: 'YYYY/MM/DD',
            initialValue: false,
            autoClose: true
        });
    </script>
@endpush
