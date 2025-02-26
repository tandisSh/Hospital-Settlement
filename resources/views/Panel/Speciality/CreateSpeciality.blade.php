@extends('Panel.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">ثبت تخصص جدید</h3>
                    </div>
                    <form action="{{ route('Speciality.Store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">عنوان:</label>
                                <div class="col-sm-9">
                                    <input name="title" type="text" class="form-control form-control-lg" id="name"
                                        required />
                                    <div class="invalid-feedback">
                                        لطفاً عنوان را وارد کنید.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="status" class="col-sm-3 col-form-label">وضعیت:</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('status') is-invalid @enderror" id="userStatus"
                                        name="status">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>فعال
                                        </option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>غیرفعال
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        لطفاً وضعیت را انتخاب کنید.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">ثبت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
