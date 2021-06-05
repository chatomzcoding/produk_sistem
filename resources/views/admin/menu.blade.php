<li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-user-secret"></i>
      <p>
        Menu
        <i class="fas fa-angle-left right"></i>
        {{-- <span class="badge badge-info right">6</span> --}}
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-user nav-icon"></i>
          <p>Sub Menu 1</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-user nav-icon"></i>
          <p>Sub Menu 2</p>
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
        <a href="{{ url('/adminuser')}}" class="nav-link">
          &nbsp;&nbsp;<i class="fas fa-user nav-icon"></i>
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