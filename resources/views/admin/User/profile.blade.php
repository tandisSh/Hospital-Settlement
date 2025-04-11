@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-primary card-outline mb-4 shadow-sm">
                    <div class="card-header bg-primary text-black text-center">
                        <h3 class="card-title mb-0">پروفایل من</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img src="{{ asset('assets/images/avatar.jpg') }}"
                                 class="rounded-circle shadow-sm" width="120" height="120" alt="Profile Picture">
                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <th>نام:</th>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <th>ایمیل:</th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th>شماره تلفن:</th>
                                <td>{{ Auth::user()->phone ?? '---' }}</td>
                            </tr>
                        </table>
                        <div class="card-footer bg-light d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <a class="text-black" href="{{route('editProfile')}}">ویرایش پروفایل</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
