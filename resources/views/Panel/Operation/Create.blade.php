@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">افزودن عمل پزشکی</h3>
                    </div>

                    <form action="{{ route('operations.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">نام عمل:</label>
                                <div class="col-sm-9">
                                    <input name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                        id="name" value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="price" class="col-sm-3 col-form-label">مبلغ (تومان):</label>
                                <div class="col-sm-9">
                                    <input name="price" type="number" class="form-control form-control-lg @error('price') is-invalid @enderror"
                                        id="price" value="{{ old('price') }}" required />
                                    @error('price')
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
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>غیرفعال</option>
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
                            <button type="submit" class="btn btn-primary btn-lg">ثبت عمل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
