@extends('Panel.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">ثبت نقش جدید</h3>
                    </div>
                    <form action="{{ route('DoctorRole.Store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <!-- عنوان نقش -->
                            <div class="mb-3 row">
                                <label for="title" class="col-sm-3 col-form-label">عنوان:</label>
                                <div class="col-sm-9">
                                    <input name="title" type="text" 
                                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                           id="title" 
                                           value="{{ old('title') }}"
                                           required />
                                    @error('title')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- وضعیت -->
                            <div class="mb-3 row">
                                <label for="status" class="col-sm-3 col-form-label">وضعیت:</label>
                                <div class="col-sm-9">
                                    <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status">
                                        <option value="1" {{ old('status', 1) == '1' ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ old('status', 1) == '0' ? 'selected' : '' }}>غیرفعال</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- سهمیه (Quota) -->
                            <div class="mb-3 row">
                                <label for="quota" class="col-sm-3 col-form-label">سهمیه (%):</label>
                                <div class="col-sm-9">
                                    <input type="number" 
                                           name="quota" 
                                           id="quota" 
                                           class="form-control form-control-lg @error('quota') is-invalid @enderror"
                                           min="1" 
                                           max="100" 
                                           value="{{ old('quota', 1) }}" 
                                           required />
                                    @error('quota')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- گزینه "الزامی" -->
                            <div class="mb-3 row">
                                <label for="required" class="col-sm-3 col-form-label">الزامی:</label>
                                <div class="col-sm-9 d-flex align-items-center">
                                    <input type="checkbox" 
                                           name="required" 
                                           id="required" 
                                           value="1"
                                           class="form-check-input ms-2 @error('required') is-invalid @enderror" 
                                           {{ old('required', 0) ? 'checked' : '' }} />
                                    <label for="required" class="mb-0">بله</label>
                                    @error('required')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
