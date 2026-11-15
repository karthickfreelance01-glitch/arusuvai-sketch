@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Rewards & Offers'))
@section('page_title', __('Rewards & Offers'))
@section('page_sub', __('Loyalty programme, birthday offers & coupons'))
@section('content')
<div class="dgrid g4">
  <div class="card kpi dark"><span class="ico">🏆</span><div class="lbl">{{ __('Members earning points') }}</div><div class="val">1,192</div><div class="delta">96% {{ __('of subscribers') }}</div></div>
  <div class="card kpi"><span class="ico">🔁</span><div class="lbl">{{ __('Renewal rate') }}</div><div class="val">87%</div><div class="delta">↑ 9% {{ __('since rewards launch') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--chilli-100)">🎂</span><div class="lbl">{{ __('Birthday offers sent') }}</div><div class="val">64</div><div class="delta">41 {{ __('redeemed') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--turmeric-100)">👥</span><div class="lbl">{{ __('Referrals this month') }}</div><div class="val">58</div><div class="delta">AED 2,900 {{ __('given') }}</div></div>
</div>

<div class="dgrid g3">
  <div class="card">
    <div class="card-h"><h3>🏆 {{ __('Loyalty tiers') }}</h3></div>
    @foreach([['🍃','Green Leaf','0 – 999 pts','1x','var(--leaf-100)'],['🌿','Gold Leaf','1,000 – 1,999 pts','1.5x','var(--turmeric-100)'],['🌴','Platinum Leaf','2,000+ pts','2x + free Sadya','var(--sky-100)']] as $t)
      <div class="setrow"><span style="width:44px;height:44px;border-radius:14px;background:{{ $t[4] }};display:grid;place-items:center;font-size:20px">{{ $t[0] }}</span><div><b>{{ $t[1] }}</b><small>{{ $t[2] }}</small></div><span class="pill">{{ $t[3] }}</span></div>
    @endforeach
    <div class="field" style="margin-top:14px"><label>{{ __('Points per meal') }}</label><input class="input" type="number" value="10"></div>
  </div>
  <div class="card bday">
    <div class="card-h"><h3>🎂 {{ __('Birthday automation') }}</h3><label class="switch"><input type="checkbox" checked><span></span></label></div>
    <div class="big">20% OFF</div>
    <p style="color:#ffe1e6">{{ __('Sent automatically 3 days before the birthday via WhatsApp, with a free payasam on the day.') }}</p>
    <div class="flex wrap"><span class="pill" style="background:rgba(255,255,255,.2);color:#fff">{{ __('Code') }}: BDAY20</span><span class="pill" style="background:rgba(255,255,255,.2);color:#fff">+250 {{ __('pts') }}</span></div>
    <div style="margin-top:18px;font-weight:700">🎈 23 {{ __('birthdays this week') }}</div>
  </div>
  <div class="card">
    <div class="card-h"><h3>👥 {{ __('Referral programme') }}</h3><label class="switch"><input type="checkbox" checked><span></span></label></div>
    <div class="row-2">
      <div class="field"><label>{{ __('Friend gets') }}</label><div class="input-group"><span class="pre">AED</span><input value="50"></div></div>
      <div class="field"><label>{{ __('Referrer gets') }}</label><div class="input-group"><input value="500"><span class="pre" style="border-right:0;border-left:1.5px solid var(--line-2)">pts</span></div></div>
    </div>
    <div class="setrow"><span>🥇</span><div><b>Senthil Kumar</b><small>9 {{ __('referrals') }}</small></div></div>
    <div class="setrow"><span>🥈</span><div><b>Anoop Menon</b><small>6 {{ __('referrals') }}</small></div></div>
  </div>
</div>

<div class="dgrid g21">
  <div class="card">
    <div class="card-h"><h3>🎟️ {{ __('Coupons') }}</h3><button class="btn btn-sm" data-toast="{{ __('Coupon created') }}|DIWALI15|🎟️">＋ {{ __('New coupon') }}</button></div>
    <div class="table-wrap">
      <table class="t">
        <thead><tr><th>{{ __('Code') }}</th><th>{{ __('Offer') }}</th><th>{{ __('Used') }}</th><th>{{ __('Valid till') }}</th><th>{{ __('Status') }}</th></tr></thead>
        <tbody>
          @foreach([['WELCOME10','10% off first month','212 / ∞','31 Dec','Active'],['BDAY20','20% off birthday month','41 / ∞','—','Active'],['ONAM25','25% off Onam week','388 / 400','15 Sep','Ended'],['PONGAL15','15% off + free sweet','0 / 300','20 Jan','Scheduled'],['FRIEND50','AED 50 referral','58 / ∞','—','Active']] as $c)
            <tr><td><code style="font-weight:800;background:var(--turmeric-50);padding:4px 8px;border-radius:6px">{{ $c[0] }}</code></td><td>{{ __($c[1]) }}</td><td>{{ $c[2] }}</td><td>{{ $c[3] }}</td><td><span class="pill {{ $c[4]==='Ended' ? 'grey' : ($c[4]==='Scheduled' ? 'sky' : '') }}">{{ __($c[4]) }}</span></td></tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>🪔 {{ __('Festival campaign') }}</h3></div>
    <div class="field"><label>{{ __('Campaign') }}</label><select class="select"><option>Pongal Special (Jan)</option><option>Onam Sadya (Aug–Sep)</option><option>Diwali Sweets (Oct–Nov)</option><option>Vishu Kani (Apr)</option></select></div>
    <div class="field"><label>{{ __('Audience') }}</label><select class="select"><option>{{ __('All active subscribers') }} (1,248)</option><option>{{ __('Expired in last 60 days') }} (312)</option><option>{{ __('Gold & Platinum members') }} (402)</option></select></div>
    <div class="field"><label>{{ __('Offer') }}</label><input class="input" value="15% off + free Pongal sweet"></div>
    <a href="{{ route('admin.notifications') }}" class="btn btn-spice btn-block">{{ __('Continue to message') }} →</a>
  </div>
</div>
@endsection
