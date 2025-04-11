@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title mb-0">افزودن عمل پزشکی</h5>
                    </div>

                    <form action="{{ route('operations.store') }}" method="POST" class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small">نام عمل:</label>
                                    <input name="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">مبلغ (تومان):</label>
                                    <input name="price" type="number" class="form-control form-control-sm @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}" required />
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">وضعیت:</label>
                                    <select name="status" class="form-control form-control-sm @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>غیرفعال</option>
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
                            <button type="submit" class="btn btn-primary btn-sm px-4">ثبت عمل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
