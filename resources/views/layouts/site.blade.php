<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  @include('partials.head')
  @stack('head')
</head>
<body>
@php $b = config('arusuvai.brand'); @endphp
<div class="topbar-strip">
  <div class="container">
    <div class="ticker">
      <span>🍃 {{ __('Fresh & homely food, cooked daily') }}</span>
      <span class="hide-sm">📍 {{ $b['location'] }}</span>
      <span class="hide-sm">🎁 {{ __('Use code') }} <a href="{{ route('book') }}">WELCOME10</a> {{ __('for 10% off your first month') }}</span>
    </div>
    <div class="flex">
      <span class="hide-sm">📞 {{ __('Support') }}: <a href="tel:{{ $b['support'] }}">{{ $b['support'] }}</a></span>
      <span>🚚 <a href="tel:{{ $b['delivery'] }}">{{ $b['delivery'] }}</a></span>
    </div>
  </div>
</div>

<header class="nav">
  <div class="container">
    <a href="{{ route('home') }}" class="brand">
      <img src="{{ asset('assets/img/logo.png') }}" alt="Arusuvai">
      <span>Arusuvai<small>{{ __('Mess · DIP 2') }}</small></span>
    </a>
    <nav class="nav-links">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('Home') }}</a>
      <a href="{{ route('home') }}#plans">{{ __('Plans') }}</a>
      <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}">{{ __('Menu') }}</a>
      <a href="{{ route('meal-change') }}" class="{{ request()->routeIs('meal-change') ? 'active' : '' }}">{{ __('Meal Change') }}</a>
      <a href="{{ route('account.track') }}">{{ __('Track Order') }}</a>
    </nav>
    <div class="nav-actions">
      @include('partials.lang')
      <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">{{ __('Login') }}</a>
      <a href="{{ route('book') }}" class="btn btn-spice btn-sm">{{ __('Book Now') }} <span class="arrow">→</span></a>
      <button class="burger" data-burger aria-label="Menu"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M4 7h16M4 12h16M4 17h10"/></svg></button>
    </div>
  </div>
</header>
<div class="mobile-menu">
  <a href="{{ route('home') }}">{{ __('Home') }}</a>
  <a href="{{ route('home') }}#plans">{{ __('Plans') }}</a>
  <a href="{{ route('menu') }}">{{ __('Menu') }}</a>
  <a href="{{ route('meal-change') }}">{{ __('Meal Change') }}</a>
  <a href="{{ route('account.track') }}">{{ __('Track Order') }}</a>
  <a href="{{ route('login') }}">{{ __('Login') }}</a>
  <a href="{{ route('book') }}" class="btn btn-spice btn-block" style="margin-top:16px;color:#fff">{{ __('Book Now') }}</a>
</div>

<main>@yield('content')</main>

@include('partials.footer')

<a class="wa-fab" href="https://wa.me/{{ $b['whatsapp'] }}?text={{ urlencode('Hi Arusuvai Mess, I would like to know about the 30 days meal plan.') }}" target="_blank" rel="noopener" aria-label="WhatsApp">
  <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.8-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1s-1.2-.5-2.4-1.5c-.9-.8-1.5-1.8-1.6-2.1-.2-.3 0-.5.1-.6l.4-.5.3-.5c.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.3zM12 21.8c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A9.8 9.8 0 1 1 12 21.8zm0-21.6A11.8 11.8 0 0 0 1.9 18l-1.7 6 6.2-1.6A11.8 11.8 0 1 0 12 .2z"/></svg>
</a>

<script src="{{ asset('assets/js/app.js') }}?v=1"></script>
@stack('scripts')
</body>
</html>
