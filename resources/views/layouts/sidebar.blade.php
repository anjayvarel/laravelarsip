<ul class="navbar-nav sidebar sidebar-dark accordion shadow" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center mt-4 mb-3" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('template/img/uptd.png') }}" alt="Logo" style="max-height: 90px;">
        </div>
    </a>

    <hr class="sidebar-divider my-2" />
    <li class="nav-item {{ request()->routeIs(Auth::user()->role . '.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(Auth::user()->role . '.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <div class="sidebar-heading">Pengelolaan Arsip</div>

    
    
    <li class="nav-item {{ request()->routeIs(Auth::user()->role . '.surat.masuk') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(Auth::user()->role . '.surat.masuk') }}">
            <i class="fas fa-fw fa-envelope-open-text"></i>
            <span>Surat Masuk</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->routeIs(Auth::user()->role . '.surat.keluar') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(Auth::user()->role . '.surat.keluar') }}">
            <i class="fas fa-fw fa-paper-plane"></i>
            <span>Surat Keluar</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->routeIs(Auth::user()->role . '.agenda.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(Auth::user()->role . '.agenda.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Agenda Acara</span>
        </a>
    </li>
    
    
    @if(Auth::user()->role == 'admin')
    @php
        $kelolaActive = request()->is('admin/kategori*') || request()->is('admin/users*');
    @endphp

    <hr class="sidebar-divider" />
    <div class="sidebar-heading">PENGATURAN</div>

    <li class="nav-item {{ $kelolaActive ? 'active' : '' }}">
        <a class="nav-link {{ $kelolaActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseSettings">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Kelola</span>
        </a>
        <div id="collapseSettings" class="collapse {{ $kelolaActive ? 'show' : '' }}">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/kategori*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">Kategori Surat</a>
                <a class="collapse-item {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Pengguna</a>
            </div>
        </div>
    </li>
@endif



    <hr class="sidebar-divider d-none d-md-block" />
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
