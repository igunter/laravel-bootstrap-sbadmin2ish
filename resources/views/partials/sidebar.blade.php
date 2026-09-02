<nav class="sb-sidebar" id="sidebar">
    <a class="sidebar-brand" href="{{ url('/') }}">
        <i class="bi bi-boxes"></i>
        <span class="sb-brand-text">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <hr class="sidebar-divider">

    <div class="sb-nav-item">
        <a class="sb-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Interface</div>

    <div class="sb-nav-item">
        <a class="sb-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="#collapseUsers" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}" aria-controls="collapseUsers">
            <i class="bi bi-people"></i>
            <span>Users</span>
            <i class="bi bi-chevron-right sb-chevron"></i>
        </a>
        <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="collapseUsers">
            <a class="sb-nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}"><span>Show All</span></a>
            <a class="sb-nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}"><span>Add New</span></a>
        </div>
    </div>

    <div class="sb-nav-item">
        <a class="sb-nav-link {{ request()->routeIs('activity-log.*') ? 'active' : '' }}" href="{{ route('activity-log.index') }}">
            <i class="bi bi-clock-history"></i>
            <span>Activity Log</span>
        </a>
    </div>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Addons</div>

    <div class="sb-nav-item">
        <a class="sb-nav-link" href="#">
            <i class="bi bi-table"></i>
            <span>Tables</span>
        </a>
    </div>

    <div class="sb-nav-item">
        <a class="sb-nav-link" href="#">
            <i class="bi bi-bar-chart-line"></i>
            <span>Charts</span>
        </a>
    </div>
</nav>
