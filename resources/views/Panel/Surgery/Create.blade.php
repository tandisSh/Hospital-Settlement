@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0 fs-5">افزودن جراحی جدید</h3>
                    </div>
                    <form action="{{ route('surgery.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <!-- اطلاعات بیمار -->
                            <div class="row g-3 mb-4">
                                <h6 class="border-bottom pb-2 mb-3">اطلاعات بیمار</h6>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="patient_name" class="form-label small">نام بیمار:</label>
                                        <input name="patient_name" type="text"
                                               class="form-control @error('patient_name') is-invalid @enderror"
                                               id="patient_name"
                                               value="{{ old('patient_name') }}"
                                               required />
                                        @error('patient_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="patient_national_code" class="form-label small">کد ملی بیمار:</label>
                                        <input name="patient_national_code" type="text"
                                               class="form-control @error('patient_national_code') is-invalid @enderror"
                                               id="patient_national_code"
                                               value="{{ old('patient_national_code') }}"
                                               required />
                                        @error('patient_national_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- اطلاعات بیمه -->
                            <div class="row g-3 mb-4">
                                <h6 class="border-bottom pb-2 mb-3">اطلاعات بیمه</h6>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="basic_insurance_id" class="form-label small">بیمه پایه:</label>
                                        <select name="basic_insurance_id"
                                                class="form-select @error('basic_insurance_id') is-invalid @enderror"
                                                id="basic_insurance_id"
                                                required>
                                            <option value="">انتخاب بیمه پایه</option>
                                            @foreach ($insurances as $insurance)
                                                @if ($insurance->type == 'basic')
                                                    <option value="{{ $insurance->id }}" {{ old('basic_insurance_id') == $insurance->id ? 'selected' : '' }}>
                                                        {{ $insurance->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('basic_insurance_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="supp_insurance_id" class="form-label small">بیمه تکمیلی:</label>
                                        <select name="supp_insurance_id"
                                                class="form-select @error('supp_insurance_id') is-invalid @enderror"
                                                id="supp_insurance_id">
                                            <option value="">انتخاب بیمه تکمیلی</option>
                                            @foreach ($insurances as $insurance)
                                                @if ($insurance->type == 'supplementary')
                                                    <option value="{{ $insurance->id }}" {{ old('supp_insurance_id') == $insurance->id ? 'selected' : '' }}>
                                                        {{ $insurance->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('supp_insurance_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- اطلاعات پزشکان -->
                            <div class="row g-3 mb-4">
                                <h6 class="border-bottom pb-2 mb-3">اطلاعات پزشکان</h6>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="surgeon_doctor_id" class="form-label small">پزشک جراح:</label>
                                        <select name="surgeon_doctor_id"
                                                class="form-select @error('surgeon_doctor_id') is-invalid @enderror"
                                                id="surgeon_doctor_id"
                                                required>
                                            <option value="">انتخاب پزشک جراح</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ old('surgeon_doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('surgeon_doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="anesthesiologist_doctor_id" class="form-label small">پزشک بیهوشی:</label>
                                        <select name="anesthesiologist_doctor_id"
                                                class="form-select @error('anesthesiologist_doctor_id') is-invalid @enderror"
                                                id="anesthesiologist_doctor_id"
                                                required>
                                            <option value="">انتخاب پزشک بیهوشی</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ old('anesthesiologist_doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('anesthesiologist_doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="consultant_doctor_id" class="form-label small">پزشک مشاور:</label>
                                        <select name="consultant_doctor_id"
                                                class="form-select @error('consultant_doctor_id') is-invalid @enderror"
                                                id="consultant_doctor_id">
                                            <option value="">انتخاب پزشک مشاور</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ old('consultant_doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('consultant_doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- اطلاعات جراحی -->
                            <div class="row g-3 mb-4">
                                <h6 class="border-bottom pb-2 mb-3">اطلاعات جراحی</h6>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="document_number" class="form-label small">شماره پرونده:</label>
                                        <input name="document_number" type="number"
                                               class="form-control @error('document_number') is-invalid @enderror"
                                               id="document_number"
                                               value="{{ old('document_number') }}"
                                               required />
                                        @error('document_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="surgery_type" class="form-label small">نوع جراحی:</label>
                                        <select name="surgery_type"
                                                class="form-select @error('surgery_type') is-invalid @enderror"
                                                id="surgery_type"
                                                required>
                                            <option value="">انتخاب نوع جراحی</option>
                                            @foreach ($operations as $type)
                                                <option value="{{ $type->id }}" {{ old('surgery_type') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('surgery_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="surgeried_at" class="form-label small">تاریخ جراحی:</label>
                                        <input name="surgeried_at" type="date"
                                               class="form-control @error('surgeried_at') is-invalid @enderror"
                                               id="surgeried_at"
                                               value="{{ old('surgeried_at') }}"
                                               required />
                                        @error('surgeried_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="released_at" class="form-label small">تاریخ ترخیص:</label>
                                        <input name="released_at" type="date"
                                               class="form-control @error('released_at') is-invalid @enderror"
                                               id="released_at"
                                               value="{{ old('released_at') }}"
                                               required />
                                        @error('released_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cost" class="form-label small">هزینه جراحی (تومان):</label>
                                        <input name="cost" type="number"
                                               class="form-control @error('cost') is-invalid @enderror"
                                               id="cost"
                                               value="{{ old('cost') }}"
                                               required />
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label small">توضیحات:</label>
                                        <textarea name="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  id="description"
                                                  rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">ثبت جراحی</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Prevent selecting same doctor for different roles
        document.querySelectorAll('select[name$="_doctor_id"]').forEach(select => {
            select.addEventListener('change', function() {
                const selectedValue = this.value;
                if (!selectedValue) return;

                document.querySelectorAll('select[name$="_doctor_id"]').forEach(otherSelect => {
                    if (otherSelect !== this) {
                        Array.from(otherSelect.options).forEach(option => {
                            if (option.value === selectedValue) {
                                option.disabled = true;
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endpush

@endsection
