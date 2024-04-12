<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
            <a href="{{route('admin.index')}}">Nhangg</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{route('admin.profile')}}" class="sidebar-link">
                <i class="lni lni-user"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{route('admin.branch.index')}}" class="sidebar-link">
                <i class="fa-solid fa-code-branch"></i>
                <span>Quản lý chi nhánh</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-car sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                <i class="fa-solid fa-motorcycle"></i>
                <span>Quản lý xe</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse list-car-sidebar" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="" class="sidebar-link">Mẫu xe</a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Xe</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                <i class="lni lni-layout"></i>
                <span>Multi Level</span>
            </a>
            <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                        data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                        Two Links
                    </a>
                    <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Link 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Link 2</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-users"></i>
                <span>Quản lý user</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="lni lni-cog"></i>
                <span>Setting</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer" style="text-align:center;">
        <form action="{{route('admin.logout')}}" method="POST">
            @csrf
            <button type="submit" href="{{route('admin.logout')}}" class="sidebar-link"
                style="border: none;
                background: none;
                font-size: 14   px;
                color: #fff;
                padding: 8px 12px;
                width: 100%;"
            >
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </button>
        
        </form>
    </div>
</aside>