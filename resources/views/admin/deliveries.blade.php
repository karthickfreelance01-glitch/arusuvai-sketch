@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Deliveries'))
@section('page_title', __('Live Deliveries'))
@section('page_sub', __('Lunch run') . ' · 1,104 ' . __('meals') . ' · 6 ' . __('riders'))
@php
  $riders = [
    ['MA','Mohammed Ashraf','#2b78c4','M80 440 L200 440 L200 120 L420 120', 'Camp Zone A', 38],
    ['SR','Suresh Raj','#c73a1d','M80 440 L560 440 L560 260 L740 260', 'DIP 2 Block C', 42],
    ['VK','Vinod Kumar','#17603a','M80 440 L80 80 L680 80', 'Green Community', 27],
    ['AJ','Ajith Joseph','#ee7a1b','M80 440 L380 440 L380 300 L620 300 L620 470', 'Jebel Ali Ind.', 31],
  ];
@endphp
@section('content')
<div class="dgrid g4">
  <div class="card kpi"><span class="ico">📦</span><div class="lbl">{{ __('Delivered') }}</div><div class="val">742</div><div class="delta">67%</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--turmeric-100)">🛵</span><div class="lbl">{{ __('On the way') }}</div><div class="val">318</div><div class="delta">6 {{ __('riders') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--sky-100)">⏱️</span><div class="lbl">{{ __('Avg. delivery time') }}</div><div class="val">21 <small style="font-size:16px">min</small></div><div class="delta">↓ 3 min</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--chilli-100)">⚠️</span><div class="lbl">{{ __('Delayed') }}</div><div class="val">4</div><div class="delta down">{{ __('Customers notified') }}</div></div>
</div>
<div class="dgrid g21">
  <div class="card" style="padding:14px;display:flex">
    <div class="map-box" id="fleet" style="flex:1;min-height:540px">
      <svg viewBox="0 0 800 520" preserveAspectRatio="xMidYMid slice">
        <defs><pattern id="blk2" width="40" height="40" patternUnits="userSpaceOnUse"><rect width="40" height="40" fill="#e3ecdf"/><rect x="4" y="4" width="32" height="32" rx="4" fill="#d8e6d3"/></pattern></defs>
        <rect width="800" height="520" fill="url(#blk2)"/>
        <path d="M0 80 H800 M0 120 H800 M0 260 H800 M0 300 H800 M0 440 H800 M80 0 V520 M200 0 V520 M380 0 V520 M560 0 V520 M620 0 V520" stroke="#fff" stroke-width="18"/>
        @foreach($riders as $i => $r)
          <path id="rp{{ $i }}" d="{{ $r[3] }}" stroke="{{ $r[2] }}" stroke-width="5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="2 10" opacity=".9"/>
        @endforeach
        <circle cx="80" cy="440" r="22" fill="#0e3b22"/><text x="80" y="447" text-anchor="middle" font-size="20">🍳</text>
      </svg>
      @foreach($riders as $i => $r)
        <div class="rider" data-rider="{{ $i }}" style="background:{{ $r[2] }};width:42px;height:42px;margin:-21px 0 0 -21px;font-size:13px;color:#fff;font-weight:800;box-shadow:0 0 0 6px {{ $r[2] }}33,var(--sh-2)">{{ $r[0] }}</div>
      @endforeach
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('Riders') }}</h3><span class="pill gold"><span class="dot"></span> {{ __('Live') }}</span></div>
    @foreach($riders as $i => $r)
      <div class="setrow"><div class="who" style="flex:1"><span class="av" style="background:{{ $r[2] }}">{{ $r[0] }}</span><div><b>{{ $r[1] }}</b><small>{{ $r[4] }} · {{ $r[5] }} {{ __('drops') }}</small></div></div><b data-pct="{{ $i }}">0%</b></div>
    @endforeach
    <div class="card-h" style="margin-top:20px"><h3>{{ __('Next drops') }}</h3></div>
    @foreach([['Room 214','Karthik R.','2 min','pill gold'],['Room 118','Anoop M.','6 min','pill gold'],['Block C 3F','12 meals','9 min','pill grey'],['Site Office','Rahul J.','14 min','pill grey']] as $d)
      <div class="setrow"><span>📍</span><div><b>{{ $d[0] }}</b><small>{{ $d[1] }}</small></div><span class="{{ $d[3] }}">{{ $d[2] }}</span></div>
    @endforeach
  </div>
</div>
@endsection
@push('scripts')
<script>
(() => {
  const map = document.getElementById('fleet'), svg = map.querySelector('svg');
  const st = [.2, .5, .7, .1];
  function place() {
    const ctm = svg.getScreenCTM(), box = map.getBoundingClientRect();
    document.querySelectorAll('[data-rider]').forEach(el => {
      const i = +el.dataset.rider, path = document.getElementById('rp' + i), L = path.getTotalLength();
      const pt = path.getPointAtLength(L * st[i]), p = svg.createSVGPoint(); p.x = pt.x; p.y = pt.y; const s = p.matrixTransform(ctm);
      el.style.left = (s.x - box.left) + 'px'; el.style.top = (s.y - box.top) + 'px';
      document.querySelector(`[data-pct="${i}"]`).textContent = Math.round(st[i] * 100) + '%';
    });
  }
  place(); window.addEventListener('resize', place);
  setInterval(() => { st.forEach((v, i) => st[i] = v >= 1 ? 0 : Math.min(1, v + .01 + i * .004)); place(); }, 900);
})();
</script>
@endpush
