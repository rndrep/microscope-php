<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
    <li class="nav-item">
      <a href="#" class="nav-link">
        <svg class="admin-icon nav-icon">
          <use href="/svg/sprite.svg#table"></use>
        </svg>
        <p>
          Справочники
          <svg class="admin-icon nav-icon right">
            <use href="/svg/sprite.svg#angle-right"></use>
          </svg>
        </p>
      </a>
      <ul class="nav nav-treeview">
        @foreach($dictItems as $dictItem)
        <li class="nav-item">
          <a href="{{route('get_all_dicts', $dictItem->class)}}" class="nav-link">
            <svg class="admin-icon nav-icon">
              <use href="/svg/sprite.svg#circle"></use>
            </svg>
            <p>{{$dictItem->caption}}</p>
          </a>
        </li>
        @endforeach
      </ul>
    </li>
    <li class="nav-item">
      <a href="{{route('users.index')}}" class="nav-link">
        <svg class="admin-icon nav-icon">
          <use href="/svg/sprite.svg#users"></use>
        </svg>
        <p>Пользователи</p>
      </a>
    </li>
  </ul>
</nav>