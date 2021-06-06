<li class="nav-item">
  <a href="{{ url('/anggota')}}" class="nav-link">
    <i class="nav-icon fas fa-user"></i>
    <p class="text">Anggota</p>
  </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chalkboard-teacher"></i>
      <p>
        Manajemen Proyek
        <i class="fas fa-angle-left right"></i>
        {{-- <span class="badge badge-info right">6</span> --}}
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ url('/client')}}" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-user-tie nav-icon"></i>
          <p>Client</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/proyek')}}" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-laptop-code nav-icon"></i>
          <p>Proyek</p>
        </a>
      </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-user-tie"></i>
      <p>
        Data Master
        <i class="fas fa-angle-left right"></i>
        {{-- <span class="badge badge-info right">6</span> --}}
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ url('/info-website')}}" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-bullhorn nav-icon"></i>
          <p>Info Website</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/user')}}" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-users nav-icon"></i>
          <p>User</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/visitor')}}" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-chart-bar nav-icon"></i>
          <p>Visitor</p>
        </a>
      </li>
    </ul>
</li>