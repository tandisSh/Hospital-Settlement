@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title mb-0">افزودن بیمه جدید</h5>
                    </div>

                    <form action="{{ route('insurances.store') }}" method="POST" class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small">نام بیمه:</label>
                                    <input name="name" type="text"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">نوع بیمه:</label>
                                    <select name="type"
                                        class="form-control form-control-sm @error('type') is-invalid @enderror" required>
                                        <option value="">انتخاب نوع بیمه</option>
                                        <option value="basic" {{ old('type') == 'basic' ? 'selected' : '' }}>پایه</option>
                                        <option value="supplementary"
                                            {{ old('type') == 'supplementary' ? 'selected' : '' }}>تکمیلی</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">درصد تخفیف:</label>
                                    <input name="discount" type="number"
                                        class="form-control form-control-sm @error('discount') is-invalid @enderror"
                                        min="0" max="100" value="{{ old('discount') }}" required />
                                    @error('discount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
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
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-sm px-4">ثبت بیمه</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
