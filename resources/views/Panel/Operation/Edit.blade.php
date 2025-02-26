@extends('Panel.layouts.master')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline mb-4 shadow-sm">
                    <div class="card-header bg-warning text-white d-flex justify-content-center align-items-center">
                        <h3 class="card-title mb-0">ویرایش عمل پزشکی</h3>
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

                    <form action="{{ route('operations.update', $operation->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label">نام عمل:</label>
                                <div class="col-sm-9">
                                    <input name="name" type="text" class="form-control form-control-lg" id="name"
                                        value="{{ old('name', $operation->name) }}" required />
                                    <div class="invalid-feedback">
                                        لطفاً نام عمل را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="price" class="col-sm-3 col-form-label">مبلغ (تومان):</label>
                                <div class="col-sm-9">
                                    <input name="price" type="number" class="form-control form-control-lg" id="price"
                                        value="{{ old('price', $operation->price) }}" required />
                                    <div class="invalid-feedback">
                                        لطفاً مبلغ عمل را وارد کنید.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="status" class="col-sm-3 col-form-label">وضعیت:</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control form-control-lg" id="status" required>
                                        <option value="1" {{ $operation->status ? 'selected' : '' }}>فعال</option>
                                        <option value="0" {{ !$operation->status ? 'selected' : '' }}>غیرفعال</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        لطفاً وضعیت را انتخاب کنید.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning btn-lg">ویرایش عمل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
