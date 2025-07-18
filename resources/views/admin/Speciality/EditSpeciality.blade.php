@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header bg-warning text-black text-center">
                        <h5 class="card-title mb-0">ویرایش تخصص</h5>
                    </div>

                    <form action="{{ route('Update.Speciality', $Speciality->id) }}" method="POST"
                        class="needs-validation p-3" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small">عنوان:</label>
                                    <input name="title" type="text"
                                        class="form-control form-control-sm @error('title') is-invalid @enderror"
                                        value="{{ old('title', $Speciality->title) }}" required />
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">وضعیت:</label>
                                    <select class="form-control form-control-sm @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="1"
                                            {{ old('status', $Speciality->status) == 1 ? 'selected' : '' }}>فعال</option>
                                        <option value="0"
                                            {{ old('status', $Speciality->status) == 0 ? 'selected' : '' }}>غیرفعال</option>
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
                            <button type="submit" class="btn btn-warning btn-sm px-4">ویرایش</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
