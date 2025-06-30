<div class="sidebar-wrapper sidebar-theme">
            
    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">

            <li class="nav-item theme-text">
                <a href="" class="nav-link"> SAKIBRA</a>
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
          




            <li class="menu active">
                <a href="{{ route('user.dashboard') }}" aria-expanded="true" class="dropdown-toggle nav-link"
                style="text-decoration: none">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                        <span>Rekapitulasi</span>
                    </div>
                </a>
            </li>

            <li class="menu active">
                <a href="{{ route('user.hukuman') }}" aria-expanded="true" class="dropdown-toggle nav-link"
                style="text-decoration: none">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 21h10"/>
                            <path d="M12 3L3 14l5 5L21 7z"/>
                            <path d="M14 7l3 3"/>
                        </svg>
                        <span>Punishment</span>
                    </div>
                </a>
            </li>

  
            

            
        </ul>
        
    </nav>

</div>