<div class="sidebar">
    <div class="logo" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-bolt"></i>
            <span>Technical Test</span>
        </div>
        <div class="toggle-btn" style="cursor: pointer;">
            <i class="fas fa-angle-left"></i>
        </div>
    </div>

    <ul style="list-style: none; padding-left: 0;">

        {{-- ADMIN --}}
        @if (auth()->check() && auth()->user()->role === 'admin')
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-users-cog"></i>
                    <span>User</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/history*') ? 'active' : '' }}">
                <a href="#"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-history"></i>
                    <span>History</span>
                </a>
            </li>
        @endif

        {{-- MURID --}}
        @if (auth()->check() && auth()->user()->role === 'murid')
            <li class="{{ Request::is('murid/dashboard') ? 'active' : '' }}">
                <a href="{{ route('murid.dashboard') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('murid/profile') ? 'active' : '' }}">
                <a href="{{ route('murid.profile') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-user"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li class="{{ Request::is('gurus*') ? 'active' : '' }}">
                <a href="{{ route('guru.index') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Cari Guru</span>
                </a>
            </li>
            <li class="{{ Request::is('murid/requests*') ? 'active' : '' }}">
                <a href="{{ route('murid.requests') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Request Kerjasama</span>
                </a>
            </li>
        @endif

        {{-- GURU --}}
        @if (auth()->check() && auth()->user()->role === 'guru')
            <li class="{{ Request::is('guru/dashboard') ? 'active' : '' }}">
                <a href="{{ route('guru.dashboard') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('guru/profile') ? 'active' : '' }}">
                <a href="{{ route('guru.profile') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-user"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li class="{{ Request::is('guru/requests*') ? 'active' : '' }}">
                <a href="{{ route('guru.requests') }}"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Request Masuk</span>
                </a>
            </li>
        @endif

    </ul>
</div>