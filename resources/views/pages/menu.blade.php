@extends('layouts.site')
@section('title', __('Weekly Menu'))
@php $menu = config('arusuvai.menu'); $slots = config('arusuvai.meal_slots'); $today = now()->format('l'); @endphp

@section('content')
<section class="page-hero kolam">
  <div class="container">
    <div class="crumbs"><a href="{{ route('home') }}">{{ __('Home') }}</a> / {{ __('Menu') }}</div>
    <h1>{{ __('Weekly Menu') }}</h1>
    <p>{{ __('A rotating menu of Tamil Nadu and Kerala favourites. Cooked fresh every morning with traditional recipes.') }}</p>
    <div class="flex wrap" style="margin-top:24px">
      <div class="seg" id="cuisine-seg">
        <span class="thumb"></span>
        <button type="button" class="on" data-value="all">{{ __('All') }}</button>
        <button type="button" data-value="TN">🌶️ {{ __('Tamil Nadu') }}</button>
        <button type="button" data-value="KL">🥥 {{ __('Kerala') }}</button>
      </div>
      <a href="{{ asset('assets/img/poster.jpg') }}" download="Arusuvai-Price-Card.jpg" class="btn btn-ghost">⬇ {{ __('Download price card') }}</a>
    </div>
  </div>
</section>

<section class="container" style="display:grid;gap:22px">
  @foreach($menu as $day => $meals)
    <div class="card reveal" style="padding:22px;border-radius:28px;{{ $day === $today ? 'box-shadow:0 0 0 3px var(--turmeric),var(--sh-2)' : '' }}">
      <div class="flex between" style="margin-bottom:16px">
        <div class="flex">
          <span style="width:54px;height:54px;border-radius:16px;background:{{ $day === $today ? 'var(--turmeric)' : 'var(--leaf-100)' }};display:grid;place-items:center;font-family:var(--f-display);font-weight:800;font-size:18px;color:var(--leaf-900)">{{ __(substr($day,0,3)) }}</span>
          <div><h3 style="font-size:26px;margin:0">{{ __($day) }}</h3>@if($day === $today)<span class="pill gold">⭐ {{ __('Today') }}</span>@endif</div>
        </div>
        <a href="{{ route('meal-change') }}" class="btn btn-ghost btn-sm">🔄 {{ __('Change meal') }}</a>
      </div>
      <div class="mini-menu">
        @foreach($meals as $slot => $m)
          <div class="mm" data-region="{{ $m[2] }}">
            <img src="{{ asset('assets/img/'.$m[1]) }}" alt="" loading="lazy">
            <div><small>{{ $slots[$slot]['icon'] }} {{ __($slots[$slot]['label']) }} · {{ $slots[$slot]['time'] }}</small><b>{{ $m[0] }}</b>
              <span class="pill {{ $m[2]==='KL' ? 'gold' : '' }}" style="margin-top:8px">{{ $m[2]==='KL' ? __('Kerala') : __('Tamil Nadu') }}</span></div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
</section>

<section class="container" style="margin-top:60px">
  <div class="cta-band">
    <div><h2>{{ __('Hungry already?') }}</h2><p>{{ __('Start your 30 days meal plan today.') }}</p></div>
    <div><a href="{{ route('book') }}" class="btn btn-white btn-lg">{{ __('Book Now') }} <span class="arrow">→</span></a></div>
  </div>
</section>
@endsection

@push('scripts')
<script>
initSeg(document.getElementById('cuisine-seg'), v => {
  document.querySelectorAll('.mm').forEach(el => {
    const show = v === 'all' || el.dataset.region === v;
    el.style.transition = '.3s'; el.style.opacity = show ? 1 : .18; el.style.filter = show ? 'none' : 'grayscale(1)';
  });
});
</script>
@endpush
