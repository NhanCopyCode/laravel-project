<header style="text-align: right;">
    Xin chào, {{Auth::guard('admin')->user()->name}}
    <input id="light_input" name="background-color" value="light" type="radio" checked>Light
    <input id="dark_input" name="background-color" value="dark" type="radio">Dark
</header>