<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('dashboard') }}">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard') }}">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Manajemen Produk</li>

            <li class="nav-item {{ Request::is('pesanan') ? 'active' : '' }}">
                <a href="{{ url('pesanan') }}" class="nav-link">
                    <i class="fas fa-home"></i> <span>Pesanan</span>
                </a>
            </li>

            <li class="menu-header">Manajemen Produk</li>

            <li class="nav-item dropdown {{ Request::is('product') || Request::is('productVariant') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-box-open"></i> <span>Products</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('product') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('product') }}">Products</a>
                    </li>
                    <li class="{{ Request::is('productVariant') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('productVariant') }}">Variants & Stock</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Master Data</li>
            <li
                class="nav-item dropdown {{ Request::is('kategori') || Request::is('size') || Request::is('color') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-folder-open"></i> <span>Master Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('kategori') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('kategori') }}">Data Categories</a>
                    </li>
                    <li class="{{ Request::is('size') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('size') }}">Data Sizes</a>
                    </li>
                    <li class="{{ Request::is('color') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('color') }}">Data Colors</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
