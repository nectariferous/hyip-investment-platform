<nav class="navbar navbar-expand-lg main-navbar">
    
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li class="bars-icon-navbar">
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg ">
                    <i data-feather="menu"></i>
                </a>
            </li>
        </ul>
        <div class="search-element">
            <a href="{{ route('home') }}" target="_blank" class="gr-bg-1 text-white text-decoration-none p-2 rounded"><i
                    class="fas fa-globe-africa  mr-2"></i><span
                    class="font-weight-bold">{{ __('Visit Site') }}</span></a>
        </div>
    </form>


    <ul class="navbar-nav navbar-right">


        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{$pendingTicket->count() > 0 ? 'beep' : ''}}">
                <i data-feather="inbox"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ __('Notifications') }}

                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @forelse($pendingTicket as $pendingTicket)
                        <a href="{{ route('admin.ticket.pendingList') }}" class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ __('You Have') }} {{ $loop->iteration }} {{ __('Pending Ticket') }}
                                <div class="time text-primary">{{ $pendingTicket->created_at->diffforhumans() }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">{{ __('There are no new notifications') }}</p>
                    @endforelse
                </div>
            </div>
        </li>




        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{$pendingWithdraw->count() > 0 ? 'beep' : ''}}">
                <i data-feather="package"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ __('Notifications') }}

                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @forelse($pendingWithdraw as $pendingWithdraw)
                        <a href="{{ route('admin.withdraw.pending') }}" class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-money-bill-alt"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ __('You Have') }} {{ $loop->iteration }} {{ __('Pending Withdraw') }}
                                <div class="time text-primary">{{ $pendingWithdraw->created_at->diffforhumans() }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">{{ __('There are no new notifications') }}</p>
                    @endforelse

                </div>

            </div>
        </li>

        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{$pendingpayment->count() > 0 ? 'beep' : ''}}">
                <i data-feather="file-text"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ __('Notifications') }}

                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @forelse($pendingpayment as $pendingpayment)
                        <a href="{{ route('admin.manual.status', 'pending') }}"
                            class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ __('You Have') }} {{ $loop->iteration }} {{ __('Pending Payments') }}
                                <div class="time text-primary">{{ $pendingpayment->created_at->diffforhumans() }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">{{ __('There are no new notifications') }}</p>
                    @endforelse

                </div>

            </div>
        </li>

        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{$depositNotifications->count() > 0 ? 'beep' : ''}}">
                <i data-feather="table"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ __('Notifications') }}

                    <div class="float-right">
                        <a href="{{ route('admin.deposit.markNotification') }}">{{ __('Mark All As Read') }}</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">


                    @forelse($depositNotifications as $notification)
                        <a href="{{ route('admin.user') }}" class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ $notification->data['name'] }}
                                <div class="time text-primary">{{ $notification->created_at->diffforhumans() }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">{{ __('There are no new notifications') }}</p>
                    @endforelse

                </div>

            </div>
        </li>


        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{$notifications->count() > 0 ? 'beep' : ''}}">
                <i data-feather="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ __('Notifications') }}
                    <div class="float-right">
                        <a href="{{ route('admin.markNotification') }}">{{ __('Mark All As Read') }}</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @forelse($notifications as $notification)
                        <a href="{{ route('admin.user') }}" class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ $notification->data['name'] }}
                                <div class="time text-primary">{{ $notification->created_at->diffforhumans() }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">{{ __('There are no new notifications') }}</p>
                    @endforelse

                </div>

            </div>
        </li>


        <li class="mx-1 my-auto nav-item dropdown no-arrow">
            <select name="" id="" class="form-control selectric changeLang">
                @foreach ($language_top as $top)
                    <option value="{{ $top->short_code }}"
                        {{ session('locale') == $top->short_code ? 'selected' : '' }}>
                        {{ __(ucwords($top->name)) }}
                    </option>
                @endforeach
            </select>
        </li>



        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                <div class="d-lg-inline-block text-capitalize">{{ __('Hi') }},
                    {{ auth()->guard('admin')->user()->username }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('Profile') }}
                </a>

                <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
