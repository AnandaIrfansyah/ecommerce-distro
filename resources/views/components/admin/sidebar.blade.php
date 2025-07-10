<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Manajemen Produk</li>
            <li
                class="nav-item dropdown {{ Request::is('kategori') || Request::is('size') || Request::is('color') || Request::is('product') || Request::is('productVariant') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-boxes"></i> <span>Manajemen Produk</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('kategori') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('kategori') }}">Kategori Produk</a>
                    </li>
                    <li class="{{ Request::is('size') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('size') }}">Size Produk</a>
                    </li>
                    <li class="{{ Request::is('color') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('color') }}">Color Produk</a>
                    </li>
                    <li class="{{ Request::is('product') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('product') }}">Produk</a>
                    </li>
                    <li class="{{ Request::is('productVariant') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('productVariant') }}">Produk Variant</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
