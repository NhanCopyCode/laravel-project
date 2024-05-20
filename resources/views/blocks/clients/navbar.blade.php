<nav>
    <div class="nav__logo">
      <a href="{{route('home')}}">NhanggWebsite</a>
    </div>
    <ion-icon class="navbar-toggler" onclick="toggleNavbar()" name="menu-outline"></ion-icon>
    <ul class="nav__links">
      <li class="link"><a href="{{route('home')}}">Trang chủ</a></li>
      <li class="link"><a href="{{route('user.booking.index')}}">Đặt xe</a></li>
      <li class="link"><a href="#">Blog</a></li>
      @if (Auth::guard('web')->check())
        <li class="navbar-user-icon">
            <span class="user_icon link">
                <ion-icon ion-icon  class="link" style="margin-right: 6px;" name="person-circle-outline"></ion-icon>
                {{Auth::guard('web')->user()->name}}
            </span>
            <ul class="user_menu">
                <li class="link" >
                    <a href="{{route('user.profile')}}">Thông tin của tôi</a>
                </li>
                <li class="link" >
                    <a href="{{route('user.booking.history')}}">Lịch sử đặt xe</a>
                </li>
                <li class="link">
                    <form action="{{route('auth.logout')}}" method="POST">
                        @csrf
                        <button>Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </li>
      @else 
        <li class="link"><a href="{{route('auth.index')}}">Đăng nhập</a></li>
        <li class="link"><a href="{{route('auth.register')}}">Đăng kí</a></li>

      @endif
    </ul>
</nav>

<div id="overlay" onclick="off()"></div>