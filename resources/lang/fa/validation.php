<?php

return [
    'required' => 'فیلد :attribute الزامی است.',
    'string' => 'فیلد :attribute باید متن باشد.',
    'max' => [
        'numeric' => 'فیلد :attribute نباید بزرگتر از :max باشد.',
        'string' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
    ],
    'min' => [
        'numeric' => 'فیلد :attribute نباید کوچکتر از :min باشد.',
        'string' => 'فیلد :attribute نباید کمتر از :min کاراکتر باشد.',
    ],
    'numeric' => 'فیلد :attribute باید عدد باشد.',
    'email' => 'فرمت ایمیل وارد شده معتبر نیست.',
    'unique' => 'این :attribute قبلاً ثبت شده است.',
    'exists' => 'مقدار انتخاب شده برای :attribute معتبر نیست.',
    'boolean' => 'فیلد :attribute باید true یا false باشد.',
    'in' => 'مقدار انتخاب شده برای :attribute معتبر نیست.',
    'confirmed' => ':attribute با تکرار آن مطابقت ندارد.',
    
    'attributes' => [
        'name' => 'نام',
        'type' => 'نوع بیمه',
        'discount' => 'درصد تخفیف',
        'status' => 'وضعیت',
        'title' => 'عنوان',
        'speciality_id' => 'تخصص',
        'national_code' => 'کد ملی',
        'medical_number' => 'شماره نظام پزشکی',
        'mobile' => 'شماره موبایل',
        'password' => 'رمز عبور',
        'phone' => 'شماره تلفن',
        'email' => 'ایمیل',
        'current_password' => 'رمز عبور فعلی',
        'new_password' => 'رمز عبور جدید',
        'new_password_confirmation' => 'تکرار رمز عبور جدید',
    ],
    'custom' => [
        'phone' => [
            'required' => 'لطفا شماره تلفن خود را وارد کنید',
        ],
        'password' => [
            'required' => 'لطفا رمز عبور خود را وارد کنید',
        ],
        'surgeon_doctor_id' => [
            'required' => 'انتخاب پزشک جراح الزامی است.',
            'exists' => 'پزشک جراح انتخاب شده معتبر نیست.',
        ],
        'anesthesiologist_doctor_id' => [
            'required' => 'انتخاب پزشک بیهوشی الزامی است.',
            'exists' => 'پزشک بیهوشی انتخاب شده معتبر نیست.',
            'different' => 'پزشک بیهوشی نمی‌تواند همان پزشک جراح باشد.',
        ],
        'consultant_doctor_id' => [
            'exists' => 'پزشک مشاور انتخاب شده معتبر نیست.',
            'different' => 'پزشک مشاور نمی‌تواند با پزشک جراح یا بیهوشی یکسان باشد.',
        ],
        'surgery_type' => [
            'required' => 'انتخاب نوع جراحی الزامی است.',
            'exists' => 'نوع جراحی انتخاب شده معتبر نیست.',
        ],
        'cost' => [
            'required' => 'وارد کردن هزینه جراحی الزامی است.',
            'numeric' => 'هزینه جراحی باید عدد باشد.',
            'min' => 'هزینه جراحی نمی‌تواند منفی باشد.',
        ],
    ],
    'auth' => [
        'failed' => 'شماره تلفن یا رمز عبور اشتباه است'
    ]
]; 