<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ url('/home') }}"><img src="{{ asset('stisla/assets/img/Logo.jpg') }}" alt="logo" width="50%"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('/home') }}"></a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header" style="color: #1a8683">Menú</li>
      @if (Auth::check() && Auth::user()->role && Auth::user()->role->nombre === 'Administrador')
        <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span>Usuarios</span></a>
        </li>
        <li class="{{ request()->is('admin/proveedores*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.proveedores.index') }}">
            <i class="fas fa-briefcase"></i> <span>Proveedores</span>
          </a>
        </li>
        <li class="{{ request()->is('admin/clientes*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.clientes.index') }}">
            <i class="fas fa-address-book"></i> <span>Clientes</span>
          </a>
        </li>
        <li class="{{ request()->is('admin/almacenes*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.almacenes.index') }}">
            <i class="fas fa-warehouse"></i> <span>Almacenes</span>
          </a>
        </li>
      @endif
    </ul>
  </aside>
</div>
