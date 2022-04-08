<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
    <li class="nav-item">
      <a class="nav-link" href="{{route('rocks.index')}}">
        <svg class="admin-icon nav-icon">
          <use href="/svg/sprite.svg#database"></use>
        </svg>
        <p>Породы</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('minerals.index')}}" class="nav-link">
        <svg class="admin-icon nav-icon">
          <use href="/svg/sprite.svg#database"></use>
        </svg>
        <p>Минералы</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('fossils.index')}}" class="nav-link">
        <svg class="admin-icon nav-icon">
          <use href="/svg/sprite.svg#database"></use>
        </svg>
        <p>Окаменелости</p>
      </a>
    </li>
    @if(Auth::user()->isAdmin())
      @include('admin.sidebar-admin-rights')
    @endif
  </ul>
</nav>
