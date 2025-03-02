 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <div class="sidebar-brand">
         <a href="../index.html" class="brand-link">
             <img src="../../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                 class="brand-image opacity-75 shadow" />
             <span class="brand-text fw-light">AdminLTE 4</span>
         </a>
     </div>
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                 <li class="nav-item">
                     <ul >
                        <li class="nav-item">
                            <a href="{{route('profile')}}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>پروفایل</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('Doctors')}}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>دکترها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('Show.DoctorRole')}}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>نقش دکترها </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('Show.Speciality')}}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>تخصص ها </p>
                            </a>
                        </li>
                         <li class="nav-item">
                             <a href="{{route('insurances')}}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>بیمه</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{route('operations')}}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>عمل ها</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{route('surgeries')}}" class="nav-link">
                                 <i class="nav-icon bi bi-circle"></i>
                                 <p>عمل های جراحی</p>
                             </a>
                         </li>
                     </ul>
                 </li>
             </ul>
         </nav>
     </div>
 </aside>
