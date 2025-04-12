@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header bg-warning text-black text-center">
                        <h5 class="card-title mb-0">ویرایش عمل پزشکی</h5>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger m-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('operations.update', $operation->id) }}" method="POST" class="needs-validation p-3"
                        novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small">نام عمل:</label>
                                    <input name="name" type="text"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name', $operation->name) }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">مبلغ (تومان):</label>
                                    <input name="price" type="number"
                                        class="form-control form-control-sm @error('price') is-invalid @enderror"
                                        value="{{ old('price', $operation->price) }}" required />
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">وضعیت:</label>
                                    <select name="status"
                                        class="form-control form-control-sm @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status', $operation->status) ? 'selected' : '' }}>
                                            فعال</option>
                                        <option value="0" {{ old('status', $operation->status) ? '' : 'selected' }}>
                                            غیرفعال</option>
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
                            <button type="submit" class="btn btn-warning btn-sm px-4">ویرایش عمل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
