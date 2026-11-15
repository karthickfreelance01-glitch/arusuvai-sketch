@extends('layouts.auth')
@section('title', __('Login'))
@section('art_title', __('Welcome back! Your food is waiting.'))
@section('art_text', __('Log in to track today\'s delivery, change meals, renew your plan and redeem rewards.'))
@section('form')
<h1>{{ __('Login') }}</h1>
<p class="muted" style="margin-bottom:26px">{{ __('Use your mobile number or email address.') }}</p>
<div class="tabs" id="login-tabs"><button type="button" class="on" data-t="mobile">📱 {{ __('Mobile') }}</button><button type="button" data-t="email">✉️ {{ __('Email') }}</button></div>

<div data-pane="mobile">
  <div id="otp-step1">
    <div class="field"><label>{{ __('Mobile number') }}</label><div class="input-group"><span class="pre">🇦🇪 +971</span><input inputmode="tel" placeholder="56 619 9944" value="56 619 9944"></div></div>
    <button type="button" class="btn btn-lg btn-block" id="send-otp">{{ __('Send OTP') }} <span class="arrow">→</span></button>
  </div>
  <div id="otp-step2" style="display:none">
    <div class="field"><label>{{ __('Enter the 4-digit code sent to your WhatsApp / SMS') }}</label>
      <div class="otp">@for($i=0;$i<4;$i++)<input maxlength="1" inputmode="numeric">@endfor</div>
      <span class="hint">{{ __('Demo: any 4 digits work') }} · <a href="#" style="color:var(--leaf-700);font-weight:700" data-toast="{{ __('OTP sent again') }}|+971 56 619 9944|📲">{{ __('Resend') }}</a></span>
    </div>
    <a href="{{ route('account.home') }}" class="btn btn-spice btn-lg btn-block">{{ __('Verify & login') }} <span class="arrow">→</span></a>
  </div>
</div>

<div data-pane="email" style="display:none">
  <div class="field"><label>{{ __('Email') }}</label><input class="input" type="email" placeholder="you@example.com" value="karthik@example.com"></div>
  <div class="field"><label class="flex between">{{ __('Password') }} <a href="#" class="muted" style="font-size:13px" data-toast="{{ __('Reset link sent') }}|{{ __('Check your email inbox') }}|📧">{{ __('Forgot?') }}</a></label><input class="input" type="password" value="password"></div>
  <a href="{{ route('account.home') }}" class="btn btn-spice btn-lg btn-block">{{ __('Login') }} <span class="arrow">→</span></a>
</div>

<div class="divider">{{ __('Demo access') }}</div>
<div class="row-2">
  <a href="{{ route('account.home') }}" class="btn btn-ghost">👤 {{ __('Customer') }}</a>
  <a href="{{ route('admin.home') }}" class="btn btn-ghost">🛠️ {{ __('Admin') }}</a>
</div>
<p class="center muted" style="margin-top:26px">{{ __('New to Arusuvai?') }} <a href="{{ route('register') }}" style="color:var(--leaf-700);font-weight:800">{{ __('Create an account') }}</a></p>
@endsection
@push('scripts')
<script>
(() => {
  const tabs = document.querySelectorAll('#login-tabs button');
  tabs.forEach(t => t.addEventListener('click', () => {
    tabs.forEach(x => x.classList.toggle('on', x === t));
    document.querySelectorAll('[data-pane]').forEach(p => p.style.display = p.dataset.pane === t.dataset.t ? 'block' : 'none');
  }));
  document.getElementById('send-otp').addEventListener('click', () => {
    document.getElementById('otp-step1').style.display = 'none'; document.getElementById('otp-step2').style.display = 'block';
    toast(@json(__('OTP sent')), '+971 56 619 9944', '📲'); document.querySelector('.otp input').focus();
  });
  const otp = [...document.querySelectorAll('.otp input')];
  otp.forEach((i, n) => i.addEventListener('input', () => { if (i.value && otp[n + 1]) otp[n + 1].focus(); }));
})();
</script>
@endpush
