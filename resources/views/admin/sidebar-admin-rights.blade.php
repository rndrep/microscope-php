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
  <ul class="nav nav-pills flex-column nav-treeview">
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
