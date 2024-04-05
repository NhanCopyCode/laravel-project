<header style="text-align: right;">
    Xin chào, {{Auth::guard('admin')->user()->name}}
    <a href="{{route('switch_mode')}}"  class="mode-switcher">
        <i class="fa-regular fa-moon icon-dark"></i>
        <i class="fa-regular fa-lightbulb icon-light"></i>

    </a>
</header>