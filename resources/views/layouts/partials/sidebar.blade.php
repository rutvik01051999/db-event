@php
    $user = Auth::user();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link align-items-center text-decoration-none">
        <img src="{{ asset('dist/img/matrix.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"> DB Event</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @can('view dashboard')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon  fa fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endcan

                @canany(['view events', 'create/update events'])
                    <li class="nav-item">
                        <a href="{{ route('event.index') }}"
                            class="nav-link {{ request()->routeIs('event.*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-calendar"></i>
                            <p>
                                Events
                            </p>
                        </a>
                    </li>
                @endcanany

                @if ($user->hasRole('super-admin'))
                    <li class="nav-item {{ request()->routeIs('permission.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-shield-alt"></i>
                            <p>
                                Role & Permissions
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('permission.assign') }}"
                                    class="nav-link {{ request()->routeIs('permission.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @can('view event reports')
                    <li class="nav-item {{ request()->routeIs('report.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-file-alt"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- Event Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.event') }}"
                                    class="nav-link {{ request()->routeIs('report.event') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Event Report</p>
                                </a>
                            </li>

                            {{-- State Wise Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.state') }}"
                                    class="nav-link {{ request()->routeIs('report.state') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>State Report</p>
                                </a>
                            </li>

                            {{-- Time Band Wise Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.timeband') }}"
                                    class="nav-link {{ request()->routeIs('report.timeband') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Time Band Report</p>
                                </a>
                            </li>

                            {{-- Time Band - Date Wise Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.timeband-date') }}"
                                    class="nav-link {{ request()->routeIs('report.timeband-date') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Time Band - Date Report</p>
                                </a>
                            </li>

                            {{-- Age Mix Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.agemix') }}"
                                    class="nav-link {{ request()->routeIs('report.agemix') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Age Mix Report</p>
                                </a>
                            </li>

                            {{-- Age - Date Wise Mix Report --}}
                            <li class="nav-item">
                                <a href="{{ route('report.agemix-date') }}"
                                    class="nav-link {{ request()->routeIs('report.agemix-date') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Age - Date Wise Mix Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
