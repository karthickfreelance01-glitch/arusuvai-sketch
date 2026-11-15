@extends('layouts.dash', ['role' => 'customer'])
@section('title', __('My Subscription'))
@section('page_title', __('My Subscription'))
@php
  $c = config('arusuvai.demo_customer'); $plans = config('arusuvai.plans'); $plan = $plans[$c['plan']];
  $sched = config('arusuvai.schedules')[$c['schedule']];
  $start = \Carbon\Carbon::parse($c['start']); $end = \Carbon\Carbon::parse($c['end']);
  $used = max(0, min(30, $start->diffInDays(now())));
@endphp

@section('content')
<div class="dgrid g21">
  <div class="card">
    <div class="card-h"><h3>{{ __('Current plan') }}</h3><span class="pill"><span class="dot"></span> {{ __('Active') }}</span></div>
    <div class="dgrid g3" style="gap:16px">
      <div style="padding:18px;border-radius:18px;background:var(--leaf-50)"><small class="muted" style="font-weight:700">{{ __('Plan') }}</small><div style="font-family:var(--f-display);font-size:24px;font-weight:700">{{ __($plan['name']) }}</div><small class="muted">{{ __($plan['subtitle']) }}</small></div>
      <div style="padding:18px;border-radius:18px;background:var(--turmeric-50)"><small class="muted" style="font-weight:700">{{ __('Days') }}</small><div style="font-family:var(--f-display);font-size:24px;font-weight:700">{{ __($sched['label']) }}</div><small class="muted">{{ $sched['days'] }} {{ __('days a week') }}</small></div>
      <div style="padding:18px;border-radius:18px;background:var(--chilli-100)"><small class="muted" style="font-weight:700">{{ __('Paid') }}</small><div style="font-family:var(--f-display);font-size:24px;font-weight:700">AED {{ $plan['prices'][$c['schedule']] }}</div><small class="muted">💳 Visa •••• 4242</small></div>
    </div>
    <div style="margin-top:24px">
      <div class="flex between" style="font-weight:700;font-size:14px;margin-bottom:8px"><span>{{ $start->format('d M Y') }}</span><span>{{ $used }} / 30 {{ __('days') }}</span><span>{{ $end->format('d M Y') }}</span></div>
      <div class="progress" style="height:14px"><span style="width:{{ round($used/30*100) }}%"></span></div>
    </div>
    <div class="flex wrap" style="margin-top:24px">
      <a href="{{ route('book') }}?plan={{ $c['plan'] }}&schedule={{ $c['schedule'] }}" class="btn btn-spice">💳 {{ __('Renew for next month') }}</a>
      <a href="{{ route('book') }}?plan=three&schedule=mon-sun" class="btn btn-ghost">⬆️ {{ __('Upgrade plan') }}</a>
      <a href="{{ route('meal-change') }}" class="btn btn-ghost">🔄 {{ __('Change meal') }}</a>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('Delivery calendar') }}</h3></div>
    @include('account._calendar')
  </div>
</div>

<div class="dgrid g2">
  <div class="card">
    <div class="card-h"><h3>⏸️ {{ __('Pause or stop early') }}</h3></div>
    <p class="muted" style="margin-top:-8px">{{ __('Inform us 1 day in advance. Used days are charged at AED') }} {{ $plan['early_stop'] }}/{{ __('day') }} {{ __('within the 30 days subscription.') }}</p>
    <div class="opts c2" style="margin-bottom:16px">
      <label class="opt"><input type="radio" name="ps" value="pause" checked><div class="box"><span class="t">⏸️ {{ __('Pause dates') }}</span><span class="s">{{ __('Leave, travel, sick day') }}</span></div><span class="tick">✓</span></label>
      <label class="opt"><input type="radio" name="ps" value="stop"><div class="box"><span class="t">⏹️ {{ __('Stop early') }}</span><span class="s">{{ __('End my plan') }}</span></div><span class="tick">✓</span></label>
    </div>
    <div class="row-2">
      <div class="field"><label>{{ __('From') }}</label><input class="input" type="date" id="ps-from" value="{{ now()->addDay()->toDateString() }}" min="{{ now()->addDay()->toDateString() }}"></div>
      <div class="field"><label>{{ __('To') }}</label><input class="input" type="date" value="{{ now()->addDays(3)->toDateString() }}"></div>
    </div>
    <div style="padding:16px 18px;border-radius:16px;background:var(--turmeric-50);border:1px dashed var(--line-2);display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
      <span style="font-weight:700">{{ __('Estimated refund if you stop tomorrow') }}</span>
      <b style="font-family:var(--f-display);font-size:28px;color:var(--leaf-800)">AED {{ max(0, $plan['prices'][$c['schedule']] - ($used + 1) * $plan['early_stop']) }}</b>
    </div>
    <button class="btn btn-block" data-toast="{{ __('Request submitted') }}|{{ __('Our team will confirm on WhatsApp.') }}|✅">{{ __('Submit request') }}</button>
  </div>
  <div class="card">
    <div class="card-h"><h3>💳 {{ __('Payment history') }}</h3><a href="#">{{ __('Download all') }}</a></div>
    <div class="table-wrap">
      <table class="t">
        <thead><tr><th>{{ __('Date') }}</th><th>{{ __('Plan') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Status') }}</th><th></th></tr></thead>
        <tbody>
          @foreach([['03 Nov 2026','3 Meals · Mon–Sat',390,'Paid'],['04 Oct 2026','3 Meals · Mon–Sat',390,'Paid'],['04 Sep 2026','2 Meals · Mon–Sat',300,'Paid'],['05 Aug 2026','2 Meals · Mon–Fri',280,'Paid'],['06 Jul 2026','1 Meal · Mon–Sun',220,'Refunded 64']] as $r)
            <tr><td>{{ $r[0] }}</td><td>{{ $r[1] }}</td><td><b>AED {{ $r[2] }}</b></td><td><span class="pill {{ str_starts_with($r[3],'Ref') ? 'gold' : '' }}">{{ __($r[3]) }}</span></td><td><a href="#" class="muted" data-toast="{{ __('Receipt downloaded') }}|{{ $r[0] }}|🧾">🧾</a></td></tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
