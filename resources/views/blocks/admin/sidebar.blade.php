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
            <a href="{{route('admin.profile')}}" class="sidebar-link" title="Trang home">
                <i class="lni lni-user"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{route('admin.booking.vehicle.index')}}" class="sidebar-link" title="Quản lý thuê xe">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Quản lý thuê xe</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{route('admin.branch.index')}}" class="sidebar-link" title="Quản lý chi nhánh">
                <i class="fa-solid fa-code-branch"></i>
                <span>Quản lý chi nhánh</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{route('admin.carrentalstore.index')}}" class="sidebar-link" title="Quản lý cửa hàng">
                <i class="fa-solid fa-store"></i>
                <span>Quản lý cửa hàng</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-car sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" title="Quản lý xe"
                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                <i class="fa-solid fa-motorcycle"></i>
                <span>Quản lý xe</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse list-car-sidebar" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{route('admin.brand.index')}}" class="sidebar-link" title="Quản lý hãng xe">Hãng xe</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('admin.model.index')}}" class="sidebar-link" title="Quản lý mẫu xe">Mẫu xe</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{route('admin.vehicle.index')}}" class="sidebar-link" title="Quản lý xe">Xe</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="{{route("admin.user.index")}}" class="sidebar-link" title="Quản lý người dùng">
                <i class="fa-solid fa-users"></i>
                <span>Quản lý user</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" title="Setting">
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