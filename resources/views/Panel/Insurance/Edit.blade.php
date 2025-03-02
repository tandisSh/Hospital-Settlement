@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline mb-4 shadow-sm">
                    <div class="card-header bg-warning text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">ویرایش بیمه</h3>
                    </div>

                    <form action="{{ route('insurances.update', $insurance->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">نام بیمه:</label>
                                <div class="col-sm-9">
                                    <input name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        id="name" value="{{ old('name', $insurance->name) }}" required />
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="type" class="col-sm-3 col-form-label">نوع بیمه:</label>
                                <div class="col-sm-9">
                                    <select name="type" class="form-control form-control-lg @error('type') is-invalid @enderror"
                                        id="type" required>
                                        <option value="basic" {{ old('type', $insurance->type) == 'basic' ? 'selected' : '' }}>پایه</option>
                                        <option value="supplementary" {{ old('type', $insurance->type) == 'supplementary' ? 'selected' : '' }}>تکمیلی</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="discount" class="col-sm-3 col-form-label">درصد تخفیف:</label>
                                <div class="col-sm-9">
                                    <input name="discount" type="number" class="form-control form-control-lg @error('discount') is-invalid @enderror"
                                        id="discount" min="0" max="100" value="{{ old('discount', $insurance->discount) }}" required />
                                    @error('discount')
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
                                        <option value="1" {{ old('status', $insurance->status) ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ old('status', $insurance->status) ? '' : 'selected' }}>غیرفعال</option>
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
                            <button type="submit" class="btn btn-warning btn-lg">ویرایش بیمه</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
