@extends('layouts.dash', ['role' => 'customer'])
@section('title', __('Track Delivery'))
@section('page_title', __('Track Delivery'))
@section('page_sub', __('Order') . ' #ARU-24816 · ' . __('Lunch'))
@php $c = config('arusuvai.demo_customer'); $m = config('arusuvai.menu')[now()->format('l')]['lunch']; @endphp

@section('content')
<div class="dgrid g21">
  <div class="card" style="padding:14px;display:flex">
    <div class="map-box" id="map" style="flex:1;min-height:520px">
      <svg viewBox="0 0 800 520" preserveAspectRatio="xMidYMid slice">
        <defs><pattern id="blk" width="40" height="40" patternUnits="userSpaceOnUse"><rect width="40" height="40" fill="#e3ecdf"/><rect x="4" y="4" width="32" height="32" rx="4" fill="#d8e6d3"/></pattern></defs>
        <rect width="800" height="520" fill="url(#blk)"/>
        <path d="M0 140 H800 M0 360 H800 M180 0 V520 M520 0 V520 M0 470 L800 250" stroke="#fff" stroke-width="26"/>
        <path d="M0 140 H800 M0 360 H800 M180 0 V520 M520 0 V520" stroke="#f3eee2" stroke-width="2" stroke-dasharray="14 12"/>
        <rect x="230" y="180" width="240" height="130" rx="18" fill="#bfdcb9"/><text x="350" y="252" text-anchor="middle" font-size="15" font-weight="700" fill="#2e6b3e" font-family="sans-serif">DIP 2 Park</text>
        <rect x="560" y="400" width="200" height="90" rx="14" fill="#cfe0f0"/><text x="660" y="450" text-anchor="middle" font-size="13" font-weight="700" fill="#2b5e8a" font-family="sans-serif">Labour Camp Zone</text>
        <path id="route" d="M110 430 L180 430 L180 360 L520 360 L520 140 L690 140 L690 90" stroke="#ee7a1b" stroke-width="7" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="2 14"/>
        <path id="done" d="M110 430 L180 430 L180 360 L520 360 L520 140 L690 140 L690 90" stroke="#17603a" stroke-width="7" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <div class="pin" data-pt="110,430"><div class="b">🍳 Arusuvai {{ __('Kitchen') }}</div><div class="s">📍</div></div>
      <div class="pin" data-pt="690,90"><div class="b">🏠 {{ $c['room'] }}</div><div class="s">📍</div></div>
      <div class="rider" id="rider">🛵</div>
      <div class="map-overlay">
        <div><small class="muted" style="font-weight:700">{{ __('Arriving in') }}</small><div class="eta"><span id="eta">12</span> min</div></div>
        <div style="flex:1"><div class="progress"><span id="prog" style="width:10%"></span></div><small class="muted" style="font-weight:600" id="status-line">{{ __('Rider picked up your lunch') }}</small></div>
        <span class="pill gold"><span class="dot"></span> {{ __('Live') }}</span>
      </div>
    </div>
  </div>

  <div class="dgrid" style="gap:24px;align-content:start">
    <div class="card">
      <div class="card-h"><h3>{{ __('Your rider') }}</h3></div>
      <div class="flex">
        <div class="who"><span class="av" style="background:var(--sky);width:56px;height:56px;flex-basis:56px;font-size:18px">MA</span><div><b style="font-size:17px">Mohammed Ashraf</b><small>⭐ 4.9 · {{ __('Bike') }} · D 48213</small></div></div>
      </div>
      <div class="row-2" style="margin-top:18px">
        <a href="tel:{{ config('arusuvai.brand.delivery') }}" class="btn btn-sm">📞 {{ __('Call') }}</a>
        <a href="https://wa.me/971522047689" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">💬 {{ __('Message') }}</a>
      </div>
    </div>
    <div class="card">
      <div class="card-h"><h3>{{ __('Order status') }}</h3></div>
      <div class="timeline" id="tl">
        <div class="tl done"><span class="dot">✓</span><div><b>{{ __('Order confirmed') }}</b><small>10:02 AM</small></div></div>
        <div class="tl done"><span class="dot">✓</span><div><b>{{ __('Cooking in kitchen') }}</b><small>10:45 AM · {{ __('Fresh sambar & poriyal') }}</small></div></div>
        <div class="tl done"><span class="dot">✓</span><div><b>{{ __('Packed & sealed') }}</b><small>11:40 AM · {{ __('Temperature checked') }}</small></div></div>
        <div class="tl now" data-tl="way"><span class="dot">🛵</span><div><b>{{ __('Out for delivery') }}</b><small>11:52 AM</small></div></div>
        <div class="tl" data-tl="done"><span class="dot">🏠</span><div><b>{{ __('Delivered') }}</b><small>{{ __('Expected') }} 12:10 PM</small></div></div>
      </div>
    </div>
    <div class="card">
      <div class="card-h"><h3>{{ __('In this box') }}</h3></div>
      <div class="today"><div class="m"><img src="{{ asset('assets/img/'.$m[1]) }}" alt=""><div><small>🍛 {{ __('Lunch') }}</small><b>{{ $m[0] }}</b></div></div></div>
      <p class="muted" style="margin:14px 0 0;font-size:14px">📍 {{ $c['room'] }}, {{ $c['building'] }}, {{ $c['area'] }}</p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@php $jsLines = [__('Rider picked up your lunch'), __('Passing DIP 2 main road'), __('Almost there — 2 minutes away'), __('Delivered! Enjoy your meal 😋')]; @endphp
<script>
(() => {
  const path = document.getElementById('done'), route = document.getElementById('route');
  const map = document.getElementById('map'), rider = document.getElementById('rider');
  const len = path.getTotalLength(); path.style.strokeDasharray = len; path.style.strokeDashoffset = len;
  const svg = map.querySelector('svg');
  let t = .1; const lines = @json($jsLines);
  function place() {
    const pt = path.getPointAtLength(len * t), ctm = svg.getScreenCTM(), box = map.getBoundingClientRect();
    const p = svg.createSVGPoint(); p.x = pt.x; p.y = pt.y; const s = p.matrixTransform(ctm);
    rider.style.left = (s.x - box.left) + 'px'; rider.style.top = (s.y - box.top) + 'px';
    document.querySelectorAll('[data-pt]').forEach(pin => {
      const [x, y] = pin.dataset.pt.split(',').map(Number); const q = svg.createSVGPoint(); q.x = x; q.y = y;
      const r = q.matrixTransform(ctm); pin.style.left = (r.x - box.left) + 'px'; pin.style.top = (r.y - box.top) + 'px';
    });
    path.style.strokeDashoffset = len * (1 - t);
    document.getElementById('prog').style.width = (t * 100) + '%';
    document.getElementById('eta').textContent = Math.max(0, Math.round(12 * (1 - t) / .9));
    document.getElementById('status-line').textContent = lines[t >= 1 ? 3 : t > .75 ? 2 : t > .35 ? 1 : 0];
  }
  place(); window.addEventListener('resize', place);
  const timer = setInterval(() => {
    t = Math.min(1, t + .025); place();
    if (t >= 1) {
      clearInterval(timer);
      const way = document.querySelector('[data-tl=way]'), done = document.querySelector('[data-tl=done]');
      way.classList.replace('now', 'done'); way.querySelector('.dot').textContent = '✓';
      done.classList.add('now'); done.querySelector('.dot').textContent = '✓';
      toast(@json(__('Lunch delivered!')), @json(__('Enjoy your meal. Rate today\'s food to earn 10 points.')), '😋'); confetti();
    }
  }, 900);
})();
</script>
@endpush
