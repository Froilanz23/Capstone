<ul class="account-nav">
    <li><a href="{{route('user.index')}}" class="menu-link menu-link_us-s">Dashboard</a></li>
    <li><a href="{{route('user.orders')}}" class="menu-link menu-link_us-s">Orders</a></li>
    <li><a href="{{route('user.account.address')}}" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="{{route('user.account.details')}}" class="menu-link menu-link_us-s">Account Details</a></li>
    
    <li>
        <form method="POST" action="{{route('logout')}}" id="logout-form">
        @csrf
        <a href="{{route('logout')}}" class="menu-link menu-link_us-s" onclick="event.preventDefault();document.getElementById('logout-form').submit()">Logout</a>
        </form>
    </li>
</ul>