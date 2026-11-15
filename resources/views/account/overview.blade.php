@extends('layouts.dash', ['role' => 'customer'])
@section('title', __('My Dashboard'))
@section('page_title', __('Dashboard'))
@php
  $c = config('arusuvai.demo_customer'); $plan = config('arusuvai.plans')[$c['plan']];
  $menu = config('arusuvai.menu'); $today = now()->format('l'); $slots = config('arusuvai.meal_slots');
  $start = \Carbon\Carbon::parse($c['start']); $end = \Carbon\Carbon::parse($c['end']);
  $used = max(0, min(30, $start->diffInDays(now()))); $left = 30 - $used;
  $hour = now()->hour; $greet = $hour < 12 ? __('Good morning') : ($hour < 17 ? __('Good afternoon') : __('Good evening'));
@endphp

@section('content')
<div class="dgrid g21">
  <div class="card hero-card" style="padding:32px">
    <div class="flex between wrap" style="gap:26px;position:relative;z-index:1">
      <div style="flex:1;min-width:260px">
        <span class="pill gold">✓ {{ __($plan['name']) }} · {{ __(config('arusuvai.schedules')[$c['schedule']]['label']) }}</span>
        <h2 style="margin-top:16px">{{ $greet }}, {{ explode(' ', $c['name'])[0] }} 👋</h2>
        <p style="color:#a9c9b3;margin-bottom:22px">{{ __('Your lunch is on the way. Dinner is being prepared in our kitchen.') }}</p>
        <div class="flex wrap">
          <a href="{{ route('account.track') }}" class="btn btn-gold">🛵 {{ __('Track lunch') }}</a>
          <a href="{{ route('meal-change') }}" class="btn btn-ghost-light">🔄 {{ __('Change meal') }}</a>
          <a href="{{ route('account.subscription') }}" class="btn btn-ghost-light">⏸️ {{ __('Pause') }}</a>
        </div>
      </div>
      <div class="ring" style="--p:{{ round($used/30*100) }}"><div><b>{{ $left }}</b><small>{{ __('days left') }}</small></div></div>
    </div>
  </div>
  <div class="card bday">
    <span class="pill" style="background:rgba(255,255,255,.2);color:#fff">🎂 {{ __('Birthday month') }}</span>
    <div class="big" style="margin-top:16px">20% OFF</div>
    <p style="color:#ffe1e6;margin:8px 0 18px">{{ __('Happy birthday in advance! Enjoy a free payasam on') }} {{ \Carbon\Carbon::parse($c['birthday'])->format('d M') }} {{ __('and 20% off your renewal.') }}</p>
    <a href="{{ route('book') }}?plan={{ $c['plan'] }}&schedule={{ $c['schedule'] }}&coupon=BDAY20" class="btn btn-white btn-sm">{{ __('Renew with offer') }} →</a>
  </div>
</div>

<div class="dgrid g4">
  <div class="card kpi"><span class="ico">🍛</span><div class="lbl">{{ __('Meals this month') }}</div><div class="val" data-count="{{ $used * 3 }}">0</div><div class="delta">↑ {{ __('100% on time') }}</div></div>
  <div class="card kpi dark"><span class="ico">🏆</span><div class="lbl">{{ __('Reward points') }}</div><div class="val" data-count="{{ $c['points'] }}">0</div><div class="delta">{{ $c['tier'] }} · 160 {{ __('to Platinum') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--turmeric-100)">⏰</span><div class="lbl">{{ __('Next delivery') }}</div><div class="val">7:30<small style="font-size:18px"> PM</small></div><div class="delta">{{ __('Dinner') }} · {{ $menu[$today]['dinner'][0] }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--chilli-100)">💰</span><div class="lbl">{{ __('Saved vs. eating out') }}</div><div class="val">AED <span data-count="610">0</span></div><div class="delta">{{ __('this month') }}</div></div>
</div>

<div class="dgrid g21">
  <div class="card">
    <div class="card-h"><h3>{{ __('Today\'s meals') }} · {{ __($today) }}</h3><a href="{{ route('menu') }}">{{ __('Full menu') }} →</a></div>
    <div class="today">
      @php $st = [['pill', '✓ '.__('Delivered')], ['pill gold', '🛵 '.__('On the way')], ['pill grey', '🕒 '.__('Scheduled')]]; @endphp
      @foreach($menu[$today] as $slot => $m)
        <div class="m">
          <img src="{{ asset('assets/img/'.$m[1]) }}" alt="">
          <div><small>{{ $slots[$slot]['icon'] }} {{ __($slots[$slot]['label']) }} · {{ $slots[$slot]['time'] }}</small><b>{{ $m[0] }}</b></div>
          <span class="{{ $st[$loop->index][0] }}">{{ $st[$loop->index][1] }}</span>
        </div>
      @endforeach
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('Live delivery') }}</h3><span class="pill gold"><span class="dot"></span> {{ __('Live') }}</span></div>
    <div class="map-box" style="min-height:220px">
      <svg viewBox="0 0 300 220" preserveAspectRatio="xMidYMid slice"><rect width="300" height="220" fill="#e6efe3"/><path d="M0 70 H300 M0 160 H300 M80 0 V220 M210 0 V220" stroke="#fff" stroke-width="16"/><rect x="100" y="90" width="90" height="50" rx="8" fill="#d5e6d2"/><path d="M40 190 C 90 190, 80 110, 150 110 S 240 60, 260 40" stroke="#ee7a1b" stroke-width="4" fill="none" stroke-dasharray="7 7"/><circle cx="40" cy="190" r="8" fill="#17603a"/><circle cx="260" cy="40" r="8" fill="#c73a1d"/></svg>
      <div class="rider" style="left:50%;top:50%;width:44px;height:44px;margin:-22px 0 0 -22px;font-size:20px">🛵</div>
    </div>
    <div class="flex between" style="margin-top:16px"><div><small class="muted" style="font-weight:700">{{ __('Arriving in') }}</small><div class="eta">12 min</div></div><a href="{{ route('account.track') }}" class="btn btn-sm">{{ __('Open tracker') }} →</a></div>
  </div>
</div>

<div class="dgrid g12">
  <div class="card">
    <div class="card-h"><h3>{{ __('Quick actions') }}</h3></div>
    <div class="dgrid" style="gap:12px">
      @foreach([[route('meal-change'),'🔄',__('Change tomorrow\'s meal'),__('Before 8 PM today')],[route('account.subscription'),'⏸️',__('Pause / early stop'),__('1 day notice')],[route('book').'?plan=three&schedule=mon-sat','💳',__('Renew my plan'),__('Expires').' '.$end->format('d M')],['tel:'.config('arusuvai.brand.support'),'📞',__('Call support'),config('arusuvai.brand.support')]] as $q)
        <a href="{{ $q[0] }}" class="today"><div class="m"><span style="width:46px;height:46px;border-radius:14px;background:var(--leaf-100);display:grid;place-items:center;font-size:20px">{{ $q[1] }}</span><div><b>{{ $q[2] }}</b><small>{{ $q[3] }}</small></div><span style="margin-left:auto;color:var(--muted)">→</span></div></a>
      @endforeach
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('This month') }}</h3><div class="legend"><span><i style="background:var(--leaf-100)"></i>{{ __('Delivered') }}</span><span><i style="background:var(--turmeric)"></i>{{ __('Today') }}</span><span><i style="background:#f1ece2"></i>{{ __('Off day') }}</span></div></div>
    @include('account._calendar')
  </div>
</div>
@endsection
