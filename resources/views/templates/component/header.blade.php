<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="{{ route('movies') }}" method="get">
        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}" required="">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @guest
          <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
        @endguest

        @auth
          @if (auth()->user()->role->name === 'user')
            <li><a href="{{ route('profile.edit') }}">{{ auth()->user()->name }}</a></li>
          @else
            <li><a class="admin-header-action" href="{{ route('admin.dashboard') }}">Admin</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="post" style="display:inline;">
              @csrf
              <button type="submit"
                      class="admin-header-action">
                Logout
              </button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>