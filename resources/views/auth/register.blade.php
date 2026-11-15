@extends('layouts.auth')
@section('title', __('Register'))
@section('art_title', __('Join 1,200+ people eating like home.'))
@section('art_text', __('Create your account to book a plan, track deliveries and earn rewards. Get 100 bonus points when you sign up!'))
@section('form')
<h1>{{ __('Create account') }}</h1>
<p class="muted" style="margin-bottom:24px">{{ __('Takes less than a minute.') }}</p>
<div class="field"><label>{{ __('Full name') }}</label><input class="input" placeholder="{{ __('e.g. Karthik Ramesh') }}"></div>
<div class="field"><label>{{ __('Mobile number') }}</label><div class="input-group"><span class="pre">🇦🇪 +971</span><input inputmode="tel" placeholder="56 619 9944"></div></div>
<div class="field"><label>{{ __('Email') }} <span class="hint">({{ __('optional') }})</span></label><input class="input" type="email" placeholder="you@example.com"></div>
<div class="row-2">
  <div class="field"><label>🎂 {{ __('Birthday') }}</label><input class="input" type="date"><span class="hint">{{ __('Get a birthday treat!') }}</span></div>
  <div class="field"><label>{{ __('Preferred language') }}</label>
    <select class="select">@foreach(config('arusuvai.languages') as $code => $l)<option {{ app()->getLocale()===$code ? 'selected' : '' }}>{{ $l['native'] }}</option>@endforeach</select>
  </div>
</div>
<div class="field"><label>{{ __('Referral code') }} <span class="hint">({{ __('optional') }})</span></label><div class="input-group"><span class="pre">🎁</span><input placeholder="FRIEND50"></div></div>
<label class="check" style="margin-bottom:20px"><input type="checkbox" checked> <span>{{ __('Send me offers and delivery updates on WhatsApp') }}</span></label>
<a href="{{ route('account.home') }}" class="btn btn-spice btn-lg btn-block">{{ __('Create account') }} <span class="arrow">→</span></a>
<p class="center muted" style="margin-top:24px">{{ __('Already have an account?') }} <a href="{{ route('login') }}" style="color:var(--leaf-700);font-weight:800">{{ __('Login') }}</a></p>
@endsection
