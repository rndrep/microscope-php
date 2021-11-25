<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a class="nav-link" href="{{route('rocks.index')}}">
                <i class="fa nav-icon fa-database"></i>
                <p>Породы</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('minerals.index')}}" class="nav-link">
                <i class="fa nav-icon fa-database"></i>
                <p>Минералы</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('fossils.index')}}" class="nav-link">
                <i class="fa nav-icon fa-database"></i>
                <p>Окаменелости</p>
            </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Справочники
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @foreach($dictItems as $dictItem)
            <li class="nav-item">
              <a href="{{route('get_all_dicts', $dictItem->class)}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>{{$dictItem->caption}}</p>
              </a>
            </li>
            @endforeach
          </ul>
        </li>
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link">
                <i class="fa nav-icon fa-users"></i>
                <p>Пользователи</p>
            </a>
        </li>
    </ul>
</nav>
