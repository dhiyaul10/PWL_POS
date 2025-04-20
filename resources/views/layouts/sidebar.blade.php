<div class="sidebar"> 
  <!-- User Panel -->
  <div class="user-panel d-flex align-items-center p-3 border-bottom" style="border-color: #334155;">
      <div class="image me-2">
          <img src="{{ auth()->user()->foto ? asset('storage/uploads/user/' . auth()->user()->foto) : asset('images/default.png') }}"
               alt="User Image"
               style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #3b82f6;">
      </div>
      <div class="info">
          <a href="{{ route('profile.edit') }}" class="d-block fw-semibold text-white" style="text-decoration: none;">
              {{ auth()->user()->nama }}
          </a>
      </div>
  </div>
    <!-- SidebarSearch Form --> 
    <div class="form-inline mt-2"> 
      <div class="input-group" data-widget="sidebar-search"> 
        <input class="form-control form-control-sidebar" type="search" 
  placeholder="Search" aria-label="Search"> 
        <div class="input-group-append"> 
          <button class="btn btn-sidebar"> 
            <i class="fas fa-search fa-fw"></i> 
          </button> 
        </div> 
      </div> 
    </div> 
    <!-- Sidebar Menu --> 
    <nav class="mt-2"> 
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" 
  role="menu" data-accordion="false"> 
        <li class="nav-item"> 
          <a href="{{ url('/') }}" class="nav-link  {{ ($activeMenu == 'dashboard')? 
  'active' : '' }} "> 
            <i class="nav-icon fas fa-tachometer-alt"></i> 
            <p>Dashboard</p> 
          </a> 
        </li>
        <li class="nav-item">
          <a href="{{ route('profile.edit') }}" class="nav-link {{ ($activeMenu == 'profile') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-astronaut"></i>
              <p>Profil Saya</p>
          </a>
      </li>
        <li class="nav-header">Data Pengguna</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 
  'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Level User</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 
  'active' : '' }}"> 
            <i class="nav-icon far fa-user"></i> 
            <p>Data User</p> 
          </a> 
        <li class="nav-header">Data Barang</li> 
        <li class="nav-item"> 
          <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 
  'kategori')? 'active' : '' }} "> 
            <i class="nav-icon far fa-bookmark"></i> 
            <p>Kategori Barang</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 
  'barang')? 'active' : '' }} "> 
            <i class="nav-icon far fa-list-alt"></i> 
            <p>Data Barang</p> 
          </a> 
        </li>
         <li class="nav-item">
             <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier')?
 'active' : '' }} ">
                 <i class="nav-icon fas fa-truck"></i>
                 <p>Data Supplier</p>
             </a>
         </li> 
        <li class="nav-header">Data Transaksi</li> 
        <li class="nav-item"> 
          <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok')? 
  'active' : '' }} "> 
            <i class="nav-icon fas fa-cubes"></i> 
            <p>Stok Barang</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 
  'penjualan')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-cash-register"></i> 
            <p>Transaksi Penjualan</p> 
          </a> 
        </li> 
    <!-- Menambahkan Menu Logout -->
         <li class="nav-header">Log Out</li>
         <li class="nav-item">
         <a href="{{ url('/logout') }}" class="nav-link {{ ($activeMenu == 'logout')?
 'active' : '' }} ">
         <i class="nav-icon fas fa-sign-out-alt"></i>
         <p>Logout</p>
        </a>
     </li>
</div>  