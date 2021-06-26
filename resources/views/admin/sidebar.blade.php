<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a class="nav-link" href="{{route('rocks.index')}}">
                <i class="fa nav-icon fa-gem"></i>
                <p>Образцы пород</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('rock-types.index')}}" class="nav-link">
                <i class="fa nav-icon fa-bacon"></i>
                <p>Типы пород</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('categories.index')}}" class="nav-link">
                <i class="fa nav-icon fa-bacon"></i>
                <p>Категории</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('minerals.index')}}" class="nav-link">
                <i class="fa nav-icon fa-cookie"></i>
                <p>Минералы</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link">
                <i class="fa nav-icon fa-users"></i>
                <p>Пользователи</p>
            </a>
        </li>
    </ul>
</nav>
