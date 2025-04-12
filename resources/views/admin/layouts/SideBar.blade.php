<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin') }}" class="brand-link">
            <span class="brand-text fw-light">سیستم مدیریت بیمارستان</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <ul>
                        <li class="nav-item">
                            <a href="{{ route('admin') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>داشبورد</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>پروفایل</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Doctors') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-md"></i>
                                <p>دکترها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Show.DoctorRole') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>نقش دکترها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Show.Speciality') }}" class="nav-link">
                                <i class="nav-icon fas fa-stethoscope"></i>
                                <p>تخصص‌ها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('insurances') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-medical"></i>
                                <p>بیمه</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('operations') }}" class="nav-link">
                                <i class="nav-icon fas fa-procedures"></i>
                                <p>عمل‌ها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('surgeries') }}" class="nav-link">
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>لیست عمل‌های جراحی</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.InvoicePay') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>صورتحساب‌های پزشکان</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.InvoiceList') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>لیست صورتحساب پزشکان </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
