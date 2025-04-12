@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title mb-0">ثبت نقش جدید</h5>
                    </div>
                    <form action="{{ route('DoctorRole.Store') }}" method="POST" class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <!-- عنوان نقش -->
                                <div class="col-12">
                                    <label class="form-label small">عنوان:</label>
                                    <input name="title" type="text"
                                        class="form-control form-control-sm @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" required />
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- وضعیت -->
                                <div class="col-6">
                                    <label class="form-label small">وضعیت:</label>
                                    <select class="form-control form-control-sm @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="1" {{ old('status', 1) == '1' ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ old('status', 1) == '0' ? 'selected' : '' }}>غیرفعال
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- سهمیه (Quota) -->
                                <div class="col-6">
                                    <label class="form-label small">سهمیه (%):</label>
                                    <input type="number" name="quota"
                                        class="form-control form-control-sm @error('quota') is-invalid @enderror"
                                        min="1" max="100" value="{{ old('quota', 1) }}" required />
                                    @error('quota')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- گزینه "الزامی" -->
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="required" id="required" value="1"
                                            class="form-check-input @error('required') is-invalid @enderror"
                                            {{ old('required', 0) ? 'checked' : '' }} />
                                        <label class="form-check-label small" for="required">الزامی</label>
                                        @error('required')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-sm px-4">ثبت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
