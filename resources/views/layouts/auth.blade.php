<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>@include('partials.head')</head>
<body>
<div class="auth">
  <div class="auth-art">
    <div class="bg"></div>
    <a href="{{ route('home') }}" class="brand" style="color:#fff"><img src="{{ asset('assets/img/logo.png') }}" alt=""><span>Arusuvai Mess<small style="color:var(--turmeric)">{{ config('arusuvai.brand.tagline') }}</small></span></a>
    <div>
      <span class="eyebrow" style="color:var(--turmeric)">{{ __('30 Days Meal Plan') }}</span>
      <h2 style="margin-top:14px">@yield('art_title')</h2>
      <p style="color:#cfe3d5;font-size:18px;max-width:460px">@yield('art_text')</p>
      <div class="flex wrap" style="margin-top:26px;gap:10px">
        <span class="chip" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:#fff">🛵 {{ __('Live tracking') }}</span>
        <span class="chip" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:#fff">🏆 {{ __('Rewards') }}</span>
        <span class="chip" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:#fff">🎂 {{ __('Birthday treat') }}</span>
      </div>
    </div>
    <div class="flex" style="color:#cfe3d5;font-size:14px">⭐⭐⭐⭐⭐ <span>{{ __('Rated 4.9 by 1,200+ subscribers') }}</span></div>
  </div>
  <div class="auth-form">
    <div class="auth-box">
      <div class="flex between" style="margin-bottom:36px">
        <a href="{{ route('home') }}" class="muted" style="font-weight:700">← {{ __('Home') }}</a>
        @include('partials.lang')
      </div>
      @yield('form')
    </div>
  </div>
</div>
<script src="{{ asset('assets/js/app.js') }}?v=1"></script>
@stack('scripts')
</body>
</html>
