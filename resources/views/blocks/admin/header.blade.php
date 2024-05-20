<header style="text-align: right;">
    @if (Auth::guard('admin')->check())
        <span>Xin chào, {{Auth::guard('admin')->user()->name}}</span>
        <a href="{{route('switch_mode')}}"  class="mode-switcher">
            <i class="fa-regular fa-moon icon-dark"></i>
            <i class="fa-regular fa-lightbulb icon-light"></i>

        </a>
        <span class="notification"><i class="fa-solid fa-bell"></i></i></span>
    @else
        <h1>Bạn chưa đăng nhập</h1>
    @endif 
</header>