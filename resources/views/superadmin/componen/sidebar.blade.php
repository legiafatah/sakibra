<div class="sidebar-wrapper sidebar-theme">
            
    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">

            <li class="nav-item theme-text">
                <a href="dashboard" class="nav-link"> SAKIBRA</a>
            </li>
            <li class="nav-item toggle-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-arrow-left sidebarCollapse">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </li>
        </ul>

        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            {{-- <li class="menu active">
                <a href="#" aria-expanded="true" class="dropdown-toggle nav-link"
                     style="text-decoration: none">
                     <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li> --}}



            {{-- <li class="menu active">
                <a href="#datatables" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle" style="text-decoration: none">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Meta Data</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="datatables" data-parent="#accordionExample">
                    <li>
                        <a href="#"aria-expanded="true" class="dropdown-toggle"
                        style="text-decoration: none"> Peserta</a>
                    </li>
                    <li>
                        <a href="#"aria-expanded="true" class="dropdown-toggle nav-link"
                        style="text-decoration: none"> Juri </a>
                    </li>
                    <li>
                        <a href="#"aria-expanded="true" class="dropdown-toggle nav-link"
                        style="text-decoration: none"> Penilaian </a>
                    </li>
                   
                </ul>
            </li> --}}

            {{-- <li class="menu active">
                <a href="#" aria-expanded="true" class="dropdown-toggle nav-link"
                style="text-decoration: none">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 21h10"/>
                            <path d="M12 3L3 14l5 5L21 7z"/>
                            <path d="M14 7l3 3"/>
                        </svg>
                        <span>Admin</span>
                    </div>
                </a>
            </li> --}}

            <li class="menu active">
                <a href="{{route ('superadmin_dashboard') }}" aria-expanded="true" class="dropdown-toggle nav-link"
                style="text-decoration: none">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M4 21v-2a4 4 0 0 1 3-3.87"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Admin</span>
                </div>
                
                
                </a>
            </li>
            

            
        </ul>
        
    </nav>

</div>