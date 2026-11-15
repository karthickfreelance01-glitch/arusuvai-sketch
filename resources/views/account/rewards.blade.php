@extends('layouts.dash', ['role' => 'customer'])
@section('title', __('Rewards'))
@section('page_title', __('Rewards'))
@section('page_sub', __('Earn on every meal · redeem for free food'))
@php $c = config('arusuvai.demo_customer'); @endphp

@section('content')
<div class="dgrid g21">
  <div class="tier">
    <div class="flex between wrap">
      <div>
        <span class="pill" style="background:rgba(14,59,34,.85);color:var(--turmeric)">🏆 {{ $c['tier'] }} {{ __('member') }}</span>
        <div class="pts" style="margin-top:16px" data-count="{{ $c['points'] }}">0</div>
        <div class="nm" style="font-weight:800">{{ __('points available') }} · ≈ AED {{ floor($c['points']/10) }}</div>
      </div>
      <div style="text-align:right;color:var(--leaf-950)"><div style="font-family:var(--f-display);font-size:22px;font-weight:700">{{ $c['name'] }}</div><div style="font-weight:700;opacity:.8">{{ __('Member since') }} 2025</div></div>
    </div>
    <div style="margin-top:26px">
      <div class="flex between" style="color:var(--leaf-950);font-weight:800;font-size:14px;margin-bottom:8px"><span>{{ $c['tier'] }}</span><span>160 {{ __('points to Platinum Leaf') }}</span></div>
      <div class="progress" style="background:rgba(14,59,34,.18)"><span style="width:92%;background:var(--leaf-900)"></span></div>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>🎁 {{ __('Refer a friend') }}</h3></div>
    <p class="muted" style="margin-top:-6px">{{ __('Your friend gets AED 50 off. You get 500 points when they subscribe.') }}</p>
    <div class="input-group" style="margin:14px 0"><span class="pre">{{ __('Code') }}</span><input id="ref" value="{{ $c['referral'] }}" readonly style="font-weight:800;letter-spacing:.08em"><button class="btn btn-sm" style="margin:6px;border-radius:10px" id="copy">{{ __('Copy') }}</button></div>
    <a class="btn btn-block" style="background:#25d366" target="_blank" rel="noopener" href="https://wa.me/?text={{ urlencode('Try Arusuvai Mess home food! Use my code '.$c['referral'].' for AED 50 off: '.url('/book-now')) }}">💬 {{ __('Share on WhatsApp') }}</a>
    <div class="flex between" style="margin-top:16px;font-size:14px;font-weight:700"><span>👥 4 {{ __('friends joined') }}</span><span style="color:var(--leaf-700)">+2,000 {{ __('pts') }}</span></div>
  </div>
</div>

<div class="card">
  <div class="card-h"><h3>{{ __('Redeem your points') }}</h3><span class="muted" style="font-size:13px;font-weight:700">10 {{ __('pts') }} = AED 1</span></div>
  <div class="dgrid g4" style="gap:16px">
    @foreach([['🍮',__('Free Payasam'),__('Add to any lunch'),300],['🍛',__('Free Lunch'),__('One extra meal'),600],['🥘',__('Sunday Sadya for a friend'),__('Bring a guest'),900],['💳',__('AED 100 off renewal'),__('Next month plan'),1000],['🎂',__('Birthday cake'),__('Delivered to your room'),1500],['🗓️',__('Free week'),__('7 days of 1 meal'),2500],['🥤',__('Fresh juice x5'),__('With lunch'),450],['🏆',__('Double points day'),__('Every Friday'),200]] as $r)
      <div class="reward">
        <span class="e">{{ $r[0] }}</span><b>{{ $r[1] }}</b><small class="muted">{{ $r[2] }}</small>
        <div class="flex between" style="margin-top:auto"><span class="cost">{{ number_format($r[3]) }} {{ __('pts') }}</span>
        @if($r[3] <= $c['points'])<button class="btn btn-sm" data-redeem="{{ $r[1] }}">{{ __('Redeem') }}</button>@else<span class="pill grey">🔒 {{ number_format($r[3]-$c['points']) }}</span>@endif</div>
      </div>
    @endforeach
  </div>
</div>

<div class="dgrid g2">
  <div class="card">
    <div class="card-h"><h3>{{ __('Ways to earn') }}</h3></div>
    @foreach([['🍛',__('Every meal delivered'),'+10'],['⭐',__('Rate your meal'),'+5'],['💳',__('Renew on time'),'+200'],['🎂',__('Birthday bonus'),'+250'],['👥',__('Refer a friend'),'+500'],['📅',__('3 months streak'),'+1000']] as $w)
      <div class="setrow"><span style="font-size:22px">{{ $w[0] }}</span><div><b>{{ $w[1] }}</b></div><span class="pill">{{ $w[2] }} {{ __('pts') }}</span></div>
    @endforeach
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('Points history') }}</h3></div>
    @foreach([['🍛',__('Meals delivered').' · 14 Nov','+30'],['⭐',__('Rated Sunday Sadya'),'+5'],['💳',__('Renewal').' · Nov','+200'],['🍮',__('Redeemed Free Payasam'),'−300'],['👥',__('Referral: Anoop M.'),'+500'],['🍛',__('Meals delivered').' · 13 Nov','+30']] as $h)
      <div class="setrow"><span style="font-size:22px">{{ $h[0] }}</span><div><b>{{ $h[1] }}</b></div><b style="color:{{ str_starts_with($h[2],'−') ? 'var(--chilli)' : 'var(--leaf-700)' }}">{{ $h[2] }}</b></div>
    @endforeach
  </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('copy').addEventListener('click', () => { navigator.clipboard?.writeText(document.getElementById('ref').value); toast(@json(__('Copied!')), @json(__('Share your code with friends')), '📋'); });
document.querySelectorAll('[data-redeem]').forEach(b => b.addEventListener('click', () => { toast(@json(__('Redeemed!')), b.dataset.redeem, '🎉'); confetti(); b.textContent = '✓'; b.disabled = true; }));
</script>
@endpush
