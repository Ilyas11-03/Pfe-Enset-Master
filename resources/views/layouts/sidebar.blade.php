{{-- <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex flex-column align-items-center justify-content-center" style="height: 90px;">
        <a href="{{ route('main_admin.dashboard') }}" class="app-brand-link">
            <img src="{{ asset('assets/img/logo/full_logo_black.png') }}" alt="logo" class="custom-logo"
                style="width: 100px">
        </a>
        <a href="" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item  {{ str_contains(request()->route()->getName(), 'dashboard') ? 'active' : '' }}">
            <a href="{{ route('main_admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <!-- Gyms -->
        <li class="menu-item {{ str_contains(request()->route()->getName(), 'gyms') ? 'active' : '' }}">
            <a href="{{ route('main_admin.gyms.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dumbbell"></i>
                <div data-i18n="Gyms">Gyms</div>
            </a>
        </li>

        <!-- Plans -->
        <li class="menu-item {{ request()->routeIs('plans.index') ? 'active' : '' }}">
            <a href="{{ route('main_admin.plans.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Plans">Plans</div>
            </a>
        </li>

        <!-- Gym Plans -->
        <li class="menu-item {{ str_contains(request()->route()->getName(), 'gym-plans') ? 'active' : '' }}">
            <a href="{{ route('main_admin.gym-plans.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-briefcase"></i>
                <div data-i18n="Gym Plans">Gym Plans</div>
            </a>
        </li>



        <li class="menu-item  {{ str_contains(request()->route()->getName(), 'profile') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item  {{ str_contains(request()->route()->getName(), 'profile') ? 'active' : '' }}">
                    <a href="{{ route('main_admin.profile') }}" class="menu-link">
                        <div data-i18n="Profile">My Profile</div>
                    </a>
                </li>
                <li class="menu-item {{ str_contains(request()->route()->getName(), 'security') ? 'active' : '' }}">
                    <a href="{{ route('main_admin.security') }}" class="menu-link">
                        <div data-i18n="Security">Security</div>
                    </a>
                </li>
            </ul>
        </li>
        @if (Auth::user()->role == 'main_admin' || Auth::user()->role == 'main_admin')
            <li class="menu-item  {{ str_contains(request()->route()->getName(), 'users') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user'></i> <!-- Apple Inc. -->
                    <div data-i18n="Manage Users">Manage Users</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item  {{ str_contains(request()->route()->getName(), 'users') ? 'active' : '' }}">
                        <a href="{{ route('main_admin.users.index') }}" class="menu-link">
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endIf

    </ul>
</aside> --}}



<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex flex-column align-items-center justify-content-center" style="height: 150px;">
        <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="app-brand-link">
            @if (Auth::user()->role == 'main_admin')
                <img src="{{ asset('assets/img/logo/full_logo_black.png') }}" alt="logo" class="custom-logo"
                    style="width: 100px;">
            @else
                @if (Auth::user()->gym && Auth::user()->gym->image && Storage::exists('public/' . Auth::user()->gym->image))
                    @if (Auth::user()->gym->currentPlan && Auth::user()->gym->currentPlan->plan->name == 'Premium')
                        <img src="{{ asset('storage/' . Auth::user()->gym->image) }}" alt="Gym Logo" class="custom-logo"
                            style="width: 100px;">
                    @else
                        <img src="{{ asset('assets/img/logo/full_logo_black.png') }}" alt="My Gym" class="custom-logo"
                            style="width: 100px;">
                    @endif
                @else
                    <img src="{{ asset('assets/img/logo/full_logo_black.png') }}" alt="My Gym" class="custom-logo"
                        style="width: 100px;">
                @endif
            @endif
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Main Admin Menu -->
        @if (Auth::user()->role == 'main_admin')
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('main_admin.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'gyms') ? 'active' : '' }}">
                <a href="{{ route('main_admin.gyms.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dumbbell"></i>
                    <div data-i18n="Gyms">Gyms</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('plans.index') ? 'active' : '' }}">
                <a href="{{ route('main_admin.plans.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-package"></i>
                    <div data-i18n="Plans">Plans</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'gym-plans') ? 'active' : '' }}">
                <a href="{{ route('main_admin.gym-plans.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="Gym Plans">Gym Plans</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'users') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Manage Users">Manage Users</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ str_contains(request()->route()->getName(), 'users') ? 'active' : '' }}">
                        <a href="{{ route('main_admin.users.index') }}" class="menu-link">
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">General Settings</span>
            </li>
            <!-- Common Account Settings -->
            <li
                class="menu-item {{ str_contains(request()->route()->getName(), 'profile') || str_contains(request()->route()->getName(), 'security') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Account Settings</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'profile') ? 'active' : '' }}">
                        <a href="{{ route('main_admin.profile') }}" class="menu-link">
                            <div data-i18n="Profile">My Profile</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'security') ? 'active' : '' }}">
                        <a href="{{ route('main_admin.security') }}" class="menu-link">
                            <div data-i18n="Security">Security</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Gym Admin Menu -->
        @if (Auth::user()->role == 'gym_admin')
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('gym_admin.members.index') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.members.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Members">Members</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'staff') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.staff.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Staff">Staff</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'sports') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.sports.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dumbbell"></i> <!-- Icon for Sports -->
                    <div data-i18n="Sports">Sports</div>
                </a>
            </li>            
            <li class="menu-item {{ request()->routeIs('gym_admin.memberships.index') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.memberships.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-package"></i>
                    <div data-i18n="Memberships">Memberships</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'payments') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.payments.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-credit-card"></i>
                    <div data-i18n="Payments">Payments</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'attendance') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.attendance.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Attendance">Attendance</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'equipment') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.equipment.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dumbbell"></i>
                    <div data-i18n="Equipment">Equipment</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'expenses') ? 'active' : '' }}">
                <a href="{{ route('gym_admin.expenses.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-money"></i>
                    <div data-i18n="Expenses">Expenses</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">General Settings</span>
            </li>
            <!-- Common Account Settings -->
            <li
                class="menu-item {{ str_contains(request()->route()->getName(), 'profile') || str_contains(request()->route()->getName(), 'security') || str_contains(request()->route()->getName(), 'settings') || str_contains(request()->route()->getName(), 'billing') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Account Settings</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'profile') ? 'active' : '' }}">
                        <a href="{{ route('gym_admin.profile') }}" class="menu-link">
                            <div data-i18n="Profile">My Profile</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'security') ? 'active' : '' }}">
                        <a href="{{ route('gym_admin.security') }}" class="menu-link">
                            <div data-i18n="Security">Security</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'settings') ? 'active' : '' }}">
                        <a href="{{ route('gym_admin.settings') }}" class="menu-link">
                            <div data-i18n="Settings">Settings</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'gym_admin.billing') ? 'active' : '' }}">
                        <a href="{{ route('gym_admin.billing') }}" class="menu-link">
                            <div data-i18n="Billing">Billing & Plans</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Staff Menu -->
        @if (Auth::user()->role == 'staff')
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('staff.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'members') ? 'active' : '' }}">
                <a href="{{ route('staff.members.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Members">Members</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'payments') ? 'active' : '' }}">
                <a href="{{ route('staff.payments.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-credit-card"></i>
                    <div data-i18n="Payments">Payments</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'attendance') ? 'active' : '' }}">
                <a href="{{ route('staff.attendance.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Attendance">Attendance</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(request()->route()->getName(), 'equipment') ? 'active' : '' }}">
                <a href="{{ route('staff.equipment.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dumbbell"></i>
                    <div data-i18n="Equipment">Equipment</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">General Settings</span>
            </li>
            <!-- Common Account Settings -->
            <li
                class="menu-item {{ str_contains(request()->route()->getName(), 'profile') || str_contains(request()->route()->getName(), 'security') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Account Settings</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'profile') ? 'active' : '' }}">
                        <a href="{{ route('staff.profile') }}" class="menu-link">
                            <div data-i18n="Profile">My Profile</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ str_contains(request()->route()->getName(), 'security') ? 'active' : '' }}">
                        <a href="{{ route('staff.security') }}" class="menu-link">
                            <div data-i18n="Security">Security</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>
</aside>
