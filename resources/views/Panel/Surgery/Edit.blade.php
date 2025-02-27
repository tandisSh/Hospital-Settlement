@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline mb-4 shadow-sm">
                    <div class="card-header bg-warning text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">ویرایش جراحی</h3>
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

                    <form action="{{ route('surgery.update', $surgery->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="patient_name" class="col-sm-3 col-form-label">نام بیمار:</label>
                                <div class="col-sm-9">
                                    <input name="patient_name" type="text" class="form-control form-control-lg"
                                        id="patient_name" value="{{ old('patient_name', $surgery->patient_name) }}"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً نام بیمار را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="patient_national_code" class="col-sm-3 col-form-label">کد ملی بیمار:</label>
                                <div class="col-sm-9">
                                    <input name="patient_national_code" type="text" class="form-control form-control-lg"
                                        id="patient_national_code"
                                        value="{{ old('patient_national_code', $surgery->patient_national_code) }}"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً کد ملی بیمار را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="basic_insurance_id" class="col-sm-3 col-form-label">بیمه پایه:</label>
                                <div class="col-sm-9">
                                    <select name="basic_insurance_id" class="form-control form-control-lg"
                                        id="basic_insurance_id" required>
                                        <option value="">انتخاب بیمه پایه</option>
                                        @foreach ($insurances as $insurance)
                                            @if ($insurance->type == 'basic')
                                                <option value="{{ $insurance->id }}"
                                                    {{ $surgery->basic_insurance_id == $insurance->id ? 'selected' : '' }}>
                                                    {{ $insurance->name }}
                                            @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        لطفاً بیمه پایه را انتخاب کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="supp_insurance_id" class="col-sm-3 col-form-label">بیمه تکمیلی:</label>
                                <div class="col-sm-9">
                                    <select name="supp_insurance_id" class="form-control form-control-lg"
                                        id="supp_insurance_id">
                                        <option value="">انتخاب بیمه تکمیلی</option>
                                        @foreach ($insurances as $insurance)
                                            @if ($insurance->type == 'supplementary')
                                                <option value="{{ $insurance->id }}"
                                                    {{ $surgery->supp_insurance_id == $insurance->id ? 'selected' : '' }}>
                                                    {{ $insurance->name }}
                                            @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="document_number" class="col-sm-3 col-form-label">شماره پرونده:</label>
                                <div class="col-sm-9">
                                    <input name="document_number" type="number" class="form-control form-control-lg"
                                        id="document_number"
                                        value="{{ old('document_number', $surgery->document_number) }}" required />
                                    <div class="invalid-feedback">
                                        لطفاً شماره پرونده را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="description" class="col-sm-3 col-form-label">توضیحات:</label>
                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control form-control-lg" id="description" rows="3">{{ old('description', $surgery->description) }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="doctor_id" class="col-sm-3 col-form-label">پزشک جراح:</label>
                                <div class="col-sm-9">
                                    <select name="doctor_id" class="form-control form-control-lg" id="doctor_id" required>
                                        <option value="">انتخاب پزشک</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ $surgery->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        لطفاً پزشک را انتخاب کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="surgery_type" class="col-sm-3 col-form-label">نوع جراحی:</label>
                                <div class="col-sm-9">
                                    <select name="surgery_type" class="form-control form-control-lg" id="surgery_type"
                                        required>
                                        <option value="">انتخاب نوع جراحی</option>
                                        @foreach ($operations as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $surgery->operations == $type->id ? 'selected' : '' }}>
                                                {{ $type->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        لطفاً نوع جراحی را انتخاب کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="surgeried_at" class="col-sm-3 col-form-label">تاریخ جراحی:</label>
                                <div class="col-sm-9">
                                    <input name="surgeried_at" type="date" class="form-control form-control-lg"
                                        id="surgeried_at" value="{{ old('surgeried_at', $surgery->surgeried_at) }}"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً تاریخ جراحی را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="released_at" class="col-sm-3 col-form-label">تاریخ ترخیص:</label>
                                <div class="col-sm-9">
                                    <input name="released_at" type="date" class="form-control form-control-lg"
                                        id="released_at" value="{{ old('released_at', $surgery->released_at) }}"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً تاریخ ترخیص را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="cost" class="col-sm-3 col-form-label">هزینه جراحی (تومان):</label>
                                <div class="col-sm-9">
                                    <input name="cost" type="number" class="form-control form-control-lg"
                                        id="cost" value="{{ old('cost', $surgery->cost) }}" required />
                                    <div class="invalid-feedback">
                                        لطفاً هزینه جراحی را وارد کنید.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning btn-lg">ویرایش جراحی</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
