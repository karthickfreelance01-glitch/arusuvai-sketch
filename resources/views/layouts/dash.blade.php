<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('partials.head')
  @stack('head')
</head>
<body>
@php
  $role = $role ?? 'customer';
  $nav = $role === 'admin' ? [
    __('Overview') => [
      ['admin.home', '📊', __('Dashboard')],
      ['admin.subscribers', '👥', __('Subscribers'), '12'],
      ['admin.deliveries', '🛵', __('Deliveries')],
    ],
    __('Kitchen') => [
      ['admin.menu', '🍛', __('Menu & Meals')],
      ['admin.payments', '💳', __('Payments')],
    ],
    __('Growth') => [
      ['admin.marketing', '🎁', __('Rewards & Offers')],
      ['admin.notifications', '🔔', __('Notifications')],
    ],
  ] : [
    __('My Arusuvai') => [
      ['account.home', '🏠', __('Dashboard')],
      ['account.track', '🛵', __('Track Delivery')],
      ['account.subscription', '📅', __('My Subscription')],
    ],
    __('Perks') => [
      ['account.rewards', '🏆', __('Rewards')],
      ['account.notifications', '🔔', __('Notifications'), '3'],
      ['account.profile', '👤', __('Profile')],
    ],
  ];
  $me = $role === 'admin' ? ['AD', 'Admin'] : ['KR', config('arusuvai.demo_customer.name')];
@endphp
<div class="dash">
  <aside class="side">
    <a href="{{ route('home') }}" class="brand"><img src="{{ asset('assets/img/logo.png') }}" alt=""><span>Arusuvai<small style="color:var(--turmeric)">{{ $role === 'admin' ? __('Admin Panel') : __('My Account') }}</small></span></a>
    @foreach($nav as $grp => $items)
      <div class="grp">{{ $grp }}</div>
      @foreach($items as $it)
        <a href="{{ route($it[0]) }}" class="{{ request()->routeIs($it[0]) ? 'on' : '' }}"><span class="ic">{{ $it[1] }}</span>{{ $it[2] }}@isset($it[3])<span class="n">{{ $it[3] }}</span>@endisset</a>
      @endforeach
    @endforeach
    <div class="grp">{{ __('Switch') }}</div>
    @if($role === 'admin')
      <a href="{{ route('account.home') }}"><span class="ic">👤</span>{{ __('Customer view') }}</a>
    @else
      <a href="{{ route('admin.home') }}"><span class="ic">🛠️</span>{{ __('Admin view') }}</a>
    @endif
    <a href="{{ route('home') }}"><span class="ic">🌐</span>{{ __('Website') }}</a>
    <a href="{{ route('login') }}"><span class="ic">🚪</span>{{ __('Logout') }}</a>

    <div class="promo" style="margin-top:22px">
      @if($role === 'admin')
        <b>{{ __('Today') }}: 286 {{ __('meals') }}</b><small>{{ __('Breakfast dispatched · Lunch in kitchen') }}</small>
        <div class="progress" style="margin-top:12px;background:rgba(255,255,255,.12)"><span style="width:64%;background:var(--turmeric)"></span></div>
      @else
        <b>🎁 {{ __('Refer & earn') }}</b><small>{{ __('Give AED 50, get 500 points.') }}</small>
        <a href="{{ route('account.rewards') }}" class="btn btn-gold btn-sm" style="margin-top:12px;width:100%">{{ __('Invite friends') }}</a>
      @endif
    </div>
  </aside>

  <div class="main">
    <header class="dtop">
      <button class="icon-btn dash-mobile-bar" data-side-toggle aria-label="Menu">☰</button>
      <div>
        <h1>@yield('page_title')</h1>
        <div class="sub">@yield('page_sub', now()->format('l, d F Y'))</div>
      </div>
      <label class="search">🔍 <input placeholder="{{ $role === 'admin' ? __('Search customers, orders…') : __('Search…') }}"></label>
      @include('partials.lang')
      <div style="position:relative" data-dropdown>
        <button class="icon-btn" data-dropdown-btn aria-label="Notifications">🔔<span class="badge">3</span></button>
        <div class="dd" data-dropdown-menu>
          <div class="flex between" style="padding:12px 0 4px"><b>{{ __('Notifications') }}</b><a href="{{ route($role === 'admin' ? 'admin.notifications' : 'account.notifications') }}" class="muted" style="font-size:13px;font-weight:700">{{ __('View all') }}</a></div>
          @if($role === 'admin')
            <div class="notif unread"><span class="i" style="background:var(--leaf-100)">💳</span><div><b>{{ __('New payment received') }}</b><p>Rahul Joshi · AED 320</p></div><time>2m</time></div>
            <div class="notif unread"><span class="i" style="background:var(--turmeric-100)">🔄</span><div><b>{{ __('Meal change request') }}</b><p>Room 118 · {{ __('Lunch tomorrow') }}</p></div><time>18m</time></div>
            <div class="notif"><span class="i" style="background:var(--chilli-100)">⏰</span><div><b>{{ __('9 plans expire this week') }}</b><p>{{ __('Send renewal reminder') }}</p></div><time>1h</time></div>
          @else
            <div class="notif unread"><span class="i" style="background:var(--turmeric-100)">🛵</span><div><b>{{ __('Lunch is on the way!') }}</b><p>{{ __('Arriving in about 12 minutes.') }}</p></div><time>2m</time></div>
            <div class="notif unread"><span class="i" style="background:var(--chilli-100)">🎂</span><div><b>{{ __('Your birthday treat is ready') }}</b><p>{{ __('20% off your next renewal.') }}</p></div><time>1h</time></div>
            <div class="notif"><span class="i" style="background:var(--leaf-100)">🏆</span><div><b>+60 {{ __('points earned') }}</b><p>{{ __('For yesterday\'s meals.') }}</p></div><time>1d</time></div>
          @endif
        </div>
      </div>
      <div class="me"><span class="av">{{ $me[0] }}</span><b>{{ $me[1] }}</b></div>
    </header>

    <div class="dbody">@yield('content')</div>
  </div>
</div>
<script src="{{ asset('assets/js/app.js') }}?v=1"></script>
@stack('scripts')
</body>
</html>
