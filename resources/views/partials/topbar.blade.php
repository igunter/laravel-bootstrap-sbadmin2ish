<nav class="sb-topbar navbar navbar-expand navbar-light bg-white">
    <div class="container-fluid">
        <button class="btn btn-toggle-sidebar" data-sb-toggle="sidebar" type="button">
            <i class="bi bi-list"></i>
        </button>

        <a class="navbar-brand d-flex d-md-none align-items-center ms-2 me-auto fw-bold text-gray-800 text-decoration-none" href="{{ url('/') }}">
            <i class="bi bi-boxes text-primary me-2"></i>
            {{ config('app.name', 'Laravel') }}
        </a>

        <form class="d-none d-md-flex ms-3 me-auto" role="search">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown position-relative">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    <span class="badge rounded-pill bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="alertsDropdown">
                    <li><h6 class="dropdown-header">Alerts Center</h6></li>
                    <li><a class="dropdown-item small" href="#">No new alerts</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown position-relative">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-envelope"></i>
                    <span class="badge rounded-pill bg-danger">7</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="messagesDropdown">
                    <li><h6 class="dropdown-header">Message Center</h6></li>
                    <li><a class="dropdown-item small" href="#">No new messages</a></li>
                </ul>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-lg-inline text-gray-600 small me-2">
                        {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                    </span>
                    <i class="bi bi-person-circle fs-4 text-gray-400"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('users.show', auth()->user()->id) }}"><i class="bi bi-person me-2 text-gray-400"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2 text-gray-400"></i>Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('activity-log.index') }}"><i class="bi bi-clock-history me-2 text-gray-400"></i>Activity Log</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2 text-gray-400"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
