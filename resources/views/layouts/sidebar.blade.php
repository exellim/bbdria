<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ isset(Auth::user()->image) ? asset('storage/' . Auth::user()->image) : asset('assets/images/faces/face1.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2" data-toggle="tooltip" data-placement="right"
                        title="{{ Auth::user()->name }}">{{ Str::limit(Auth::user()->name, 10, '...') }}</span>
                    <span class="text-secondary text-small">{{ Auth::user()->roles[0]->name }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::path() == '/' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        @role('master')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <span class="menu-title">Master</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Branch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.index') }}">Category</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endrole
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Basic UI Elements</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
                    </li>
                </ul>
            </div>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.index') }}" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Customers</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('appointments.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('appointments.index') }}">
                <span class="menu-title">Appointments</span>
                <i class="mdi mdi-file-document-box menu-icon"></i>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('treatments.index') }}">
                <span class="menu-title">Treatments</span>
                <i class="mdi mdi-needle menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#item-list" aria-expanded="false"
                aria-controls="item-list">
                <span class="menu-title">Items</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-archive menu-icon"></i>
            </a>
            <div class="collapse" id="item-list">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('items.index') }}">Sale</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('supplies.index') }}">Supplies</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('supplies.index') }}">Supplies</a>
                    </li> --}}
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#manage-sup" aria-expanded="false"
                aria-controls="manage-sup">
                <span class="menu-title">Supplies M</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-apps-box menu-icon"></i>
            </a>
            <div class="collapse" id="manage-sup">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supply.in') ? 'active' : '' }}" href="{{ route('supply.in') }}">Supply In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supply.out') ? 'active' : '' }}" href="{{ route('supply.out') }}">Supply Out</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('supplies.index') }}">Supplies</a>
                    </li> --}}
                </ul>
            </div>
        </li>
        {{-- <li class="nav-item {{ request()->routeIs('supply.in') || request()->routeIs('supply.out') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#supplyM" aria-expanded="false"
                aria-controls="supplyM">
                <span class="menu-title">Manage Supply</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-apps-box menu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('supply.in') || request()->routeIs('supply.out') ? 'show' : '' }}" id="supplyM">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supply.in') ? 'active' : '' }}" href="{{ route('supply.in') }}">Supply In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('supply.out') ? 'active' : '' }}" href="{{ route('supply.out') }}">Supply Out</a>
                    </li>
                </ul>
            </div>
        </li> --}}
    </ul>
</nav>
