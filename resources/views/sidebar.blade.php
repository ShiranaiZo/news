<li class="sidebar-title">Menu</li>

<li class="sidebar-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
    <a href="{{ url('admin/dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

@if(in_array(\Auth::user()->role, [1]))
    <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
        <a href="{{ url('admin/users') }}" class='sidebar-link'>
            <i class="bi bi-people-fill"></i>
            <span>Users</span>
        </a>
    </li>
@endif

<li class="sidebar-item {{ request()->is('admin/articles*') ? 'active' : '' }}">
    <a href="{{ url('admin/articles') }}" class='sidebar-link'>
        <i class="bi bi-newspaper"></i>
        <span>Articles</span>
    </a>
</li>

{{-- Logout --}}
    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>
    </form>
{{-- /Logout --}}
