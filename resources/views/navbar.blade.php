<a href="#" class="burger-btn d-block">
    <i class="bi bi-justify fs-3"></i>
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
    aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    @if (Auth::user()->role == 1 && request()->is('admin/articles*'))
        <div class="float-start ms-4">
            <div class="filter-show d-flex align-items-center">
                <span class="me-2">Switch User:</span>

                <form action="{{url('/admin/switch-user')}}" id="switch_user" method="POST">
                    @csrf
                    <select name="user_id" id="switch_user_id" class="form-control" onchange="$('#switch_user').submit()">
                        <option value="{{ Auth::id() }}" {{ getUserID() == Auth::id() ? 'selected' : ''}}>Me (This Account)</option>

                        @foreach(getUsers() as $user)
                            @if ($user->id == Auth::id())
                                @continue
                            @endif

                            <option value="{{$user->id}}" {{ getUserID() == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    @endif

    <ul class="navbar-nav ms-auto mb-lg-0">
    </ul>

    <div>
        <a href="#" aria-expanded="false">
            <div class="user-menu d-flex">
                <div class="user-name text-end me-3">
                    <h6 class="mb-0 text-gray-600">{{ thisUser()->name }}</h6>
                    <p class="mb-0 text-sm text-gray-600">{{ config("custom.roles.".thisUser()->role) }}</p>
                </div>
                <div class="user-img d-flex align-items-center">
                    <div class="avatar avatar-md">
                        <img src="{{ asset('assets/images/faces/1.jpg')}}">
                    </div>
                </div>
            </div>
        </a>
        {{-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
            <li>
                <h6 class="dropdown-header">Hello, John!</h6>
            </li>
            <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                    Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                    Settings</a></li>
            <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-wallet me-2"></i>
                    Wallet</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <li><a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
            </form>
        </ul> --}}
    </div>
</div>
