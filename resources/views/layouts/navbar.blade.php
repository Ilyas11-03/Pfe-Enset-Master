<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        {{-- <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div> --}}
        <!-- /Search -->

        @if (Auth::user()->role == 'gym_admin')
            <!-- Subscription Days Left -->
            <div class="navbar-nav align-items-center">
                @php
                    $currentPlan = Auth::user()->gym->currentPlan ?? null;
                    $daysLeft = $currentPlan ? floor(now()->diffInDays($currentPlan->end_date, false)) : 0;
                @endphp
                <a href="/gym_admin/billing" class="d-flex align-items-center text-decoration-none">
                    <div class="d-flex align-items-center bg-primary rounded-pill p-1">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px;">
                            <span class="fw-bold">{{ max(0, $daysLeft) }}</span>
                        </div>
                        <span class="text-white ms-2 me-3">
                            {{ $daysLeft > 0 ? 'Days left' : 'Expired' }}
                        </span>
                    </div>
                </a>
            </div>
            <!-- /Subscription Days Left -->
        @endif

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->
            {{-- <li class="nav-item lh-1 me-3">
                <a class="github-button" href="https://github.com/themeselection/Iptv-html-admin-template-free"
                    data-icon="octicon-star" data-size="large" data-show-count="true"
                    aria-label="Star themeselection/Iptv-html-admin-template-free on GitHub">Star</a>
            </li> --}}

            <!-- User -->
            @Auth
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ Auth::user()->profile_image && Storage::exists('public/' . Auth::user()->profile_image) ? Storage::url(Auth::user()->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                alt="profile" class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route(Auth::user()->role . '.profile') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ Auth::user()->profile_image && Storage::exists('public/' . Auth::user()->profile_image) ? Storage::url(Auth::user()->profile_image) : asset('/assets/img/avatars/profile.png') }}"
                                                alt="profile" class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                        <small class="text-muted">
                                            {{ Auth::user()->role == 'main_admin' ? 'Main Admin' : (Auth::user()->role == 'gym_admin' ? 'Admin' : 'Staff') }}
                                        </small>

                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route(Auth::user()->role . '.profile') }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route(Auth::user()->role . '.security') }}">
                                <i class="bx bx-lock me-2"></i>
                                <span class="align-middle">Security</span>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'gym_admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('gym_admin.settings') }}">
                                    <i class="bx bx-dumbbell me-2"></i>
                                    <span class="align-middle">Gym Settings</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('gym_admin.billing') }}">
                                    <span class="d-flex align-items-center align-middle">
                                        <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                        <span class="flex-grow-1 align-middle">Billing</span>
                                        @if (isset($currentPlan))
                                            <span
                                                class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20"></span>
                                        @else
                                            <span
                                                class="flex-shrink-0 badge badge-center rounded-pill bg-success w-px-20 h-px-20"></span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off me-2"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endAuth
            <!--/ User -->
        </ul>
    </div>
</nav>
