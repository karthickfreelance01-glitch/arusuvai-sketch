@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Payments'))
@section('page_title', __('Payments'))
@section('page_sub', __('Powered by Stripe'))
@php $live = (bool) config('arusuvai.stripe.secret'); @endphp
@section('content')
<div class="card hero-card" style="padding:28px">
  <div class="flex between wrap" style="position:relative;z-index:1">
    <div><span class="stripe-badge">stripe</span><h2 style="margin-top:14px">AED 413,260</h2><p style="color:#a9c9b3;margin:0">{{ __('Collected this month') }} · 1,061 {{ __('payments') }} · {{ __('next payout') }} 18 Nov</p></div>
    <div class="flex wrap">
      <span class="pill {{ $live ? '' : 'gold' }}"><span class="dot"></span> {{ $live ? __('Stripe connected') : __('Demo mode — add STRIPE_SECRET in .env') }}</span>
      <a href="https://dashboard.stripe.com" target="_blank" rel="noopener" class="btn btn-gold btn-sm">{{ __('Open Stripe') }} ↗</a>
    </div>
  </div>
</div>
<div class="dgrid g4">
  <div class="card kpi"><span class="ico">💳</span><div class="lbl">{{ __('Card / Wallet') }}</div><div class="val">92%</div><div class="delta">Visa · Mastercard · Apple Pay</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--sky-100)">💵</span><div class="lbl">{{ __('Cash pending') }}</div><div class="val">AED 2,870</div><div class="delta down">9 {{ __('customers') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--chilli-100)">↩️</span><div class="lbl">{{ __('Early stop refunds') }}</div><div class="val">AED 1,145</div><div class="delta">3 {{ __('to approve') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--turmeric-100)">🎁</span><div class="lbl">{{ __('Discounts given') }}</div><div class="val">AED 6,320</div><div class="delta">WELCOME10 · BDAY20</div></div>
</div>
<div class="card">
  <div class="card-h"><h3>{{ __('Transactions') }}</h3><button class="btn btn-ghost btn-sm" data-toast="{{ __('Export started') }}|payments.csv|📥">📥 {{ __('Export CSV') }}</button></div>
  <div class="table-wrap">
    <table class="t">
      <thead><tr><th>{{ __('Reference') }}</th><th>{{ __('Customer') }}</th><th>{{ __('Plan') }}</th><th>{{ __('Method') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Date') }}</th><th>{{ __('Status') }}</th><th></th></tr></thead>
      <tbody>
        @foreach([
          ['ARU-7F3A21C9','Karthik Ramesh','3 Meals · Mon–Sat','Visa •••• 4242',390,'15 Nov, 09:12','Succeeded','pill'],
          ['ARU-1B88D0E4','Fathima Nazar','2 Meals · Mon–Fri','Cash',280,'14 Nov, 18:40','Pending','pill sky'],
          ['ARU-C2049A17','Priya Lakshmi','1 Meal · Mon–Sun','Google Pay',198,'14 Nov, 11:05','Succeeded','pill'],
          ['ARU-90E1F2B3','Deepak Nair','3 Meals · Mon–Sat','Apple Pay',390,'13 Nov, 20:21','Succeeded','pill'],
          ['ARU-55AC7E10','Arun Prakash','2 Meals · Mon–Sat','Refund',-108,'13 Nov, 10:02','Refund request','pill red'],
          ['ARU-3D7B9F66','Imran Sheikh','2 Meals · Mon–Sun','Mastercard •••• 8812',320,'12 Nov, 08:47','Succeeded','pill'],
          ['ARU-6E2C1A08','Ravi Shankar','3 Meals · Mon–Sun','Visa •••• 1881',450,'12 Nov, 07:30','Failed','pill grey'],
        ] as $t)
          <tr><td><code style="font-weight:700">{{ $t[0] }}</code></td><td><b>{{ $t[1] }}</b></td><td>{{ $t[2] }}</td><td>{{ $t[3] }}</td><td><b style="color:{{ $t[4] < 0 ? 'var(--chilli)' : 'inherit' }}">AED {{ $t[4] }}</b></td><td class="muted">{{ $t[5] }}</td><td><span class="{{ $t[7] }}"><span class="dot"></span> {{ __($t[6]) }}</span></td>
            <td>@if($t[6]==='Pending')<button class="btn btn-sm" data-toast="{{ __('Marked as paid') }}|{{ $t[1] }}|✅">{{ __('Mark paid') }}</button>@elseif($t[6]==='Refund request')<button class="btn btn-sm btn-ghost" data-toast="{{ __('Refund approved') }}|AED 108 · {{ $t[1] }}|↩️">{{ __('Approve') }}</button>@else<a href="#" class="muted" data-toast="{{ __('Receipt sent') }}|{{ $t[1] }}|🧾">🧾</a>@endif</td></tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="card">
  <div class="card-h"><h3>⚙️ {{ __('Stripe setup') }}</h3></div>
  <div class="dgrid g3" style="gap:16px">
    <div class="setrow" style="border:0"><span>🔑</span><div><b>STRIPE_KEY / STRIPE_SECRET</b><small>{{ __('Add your keys to the .env file') }}</small></div><span class="pill {{ $live ? '' : 'gold' }}">{{ $live ? '✓' : '—' }}</span></div>
    <div class="setrow" style="border:0"><span>💱</span><div><b>{{ __('Currency') }}: AED</b><small>{{ __('Card, Apple Pay & Google Pay via Checkout') }}</small></div><span class="pill">✓</span></div>
    <div class="setrow" style="border:0"><span>🔒</span><div><b>{{ __('Server-side pricing') }}</b><small>{{ __('Amounts are calculated on the server') }}</small></div><span class="pill">✓</span></div>
  </div>
</div>
@endsection
