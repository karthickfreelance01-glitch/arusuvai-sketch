@extends('layouts.site')
@section('title', __('Booking confirmed'))
@php $b = config('arusuvai.brand'); $bk = $booking ?? []; @endphp
@section('content')
<section class="section kolam" style="padding-top:70px">
  <div class="container success-wrap">
    @if($status === 'pending')
      <div class="success-ico" style="background:var(--turmeric);color:var(--leaf-950)">⏳</div>
      <h1 style="font-size:clamp(38px,5vw,60px);color:var(--leaf-950)">{{ __('Payment is processing') }}</h1>
      <p class="muted" style="font-size:18px">{{ __('We will confirm your plan as soon as Stripe confirms the payment.') }}</p>
    @else
      <div class="success-ico">✓</div>
      <span class="eyebrow"><span data-when="cash" @if($status !== 'cash') hidden @endif>{{ __('Registration received') }}</span><span data-when="paid demo" @if($status === 'cash') hidden @endif>{{ __('Payment successful') }}</span></span>
      <h1 style="font-size:clamp(38px,5vw,64px);color:var(--leaf-950);margin-top:12px">{{ __('Welcome to the Arusuvai family!') }}</h1>
      <p class="muted" style="font-size:18px">
        <span data-when="cash" @if($status !== 'cash') hidden @endif>{{ __('Our team will call you to collect the payment and confirm your start date.') }}</span>
        <span data-when="paid demo" @if($status === 'cash') hidden @endif>{{ __('Your 30 days meal plan is confirmed. A receipt has been sent to your WhatsApp and email.') }}</span>
      </p>
      <span class="pill gold" data-when="demo" style="margin-top:6px" @if($status !== 'demo') hidden @endif>🧪 {{ __('Demo mode — no real payment was taken') }}</span>
    @endif

    <div class="receipt">
      <div class="flex between wrap" style="margin-bottom:14px">
        <div><small class="muted" style="font-weight:700">{{ __('Booking reference') }}</small><div style="font-family:var(--f-display);font-size:28px;font-weight:700" data-bk="reference">{{ $bk['reference'] ?? 'ARU-DEMO' }}</div></div>
        <span class="pill sky" data-when="cash" @if($status !== 'cash') hidden @endif><span class="dot"></span> {{ __('Awaiting payment') }}</span><span class="pill" data-when="paid demo" @if($status === 'cash') hidden @endif><span class="dot"></span> {{ __('Active') }}</span>
      </div>
      <div class="calc-rows">
        <div><span>{{ __('Plan') }}</span><span data-bk="plan">{{ $bk['plan'] ?? '3 Meals Plan' }}</span></div>
        <div><span>{{ __('Days') }}</span><span data-bk="schedule">{{ $bk['schedule'] ?? 'Monday – Sunday' }}</span></div>
        @if(!empty($bk['meals']))<div><span>{{ __('Meals') }}</span><span>{{ $bk['meals'] }}</span></div>@endif
        <div><span>{{ __('Start date') }}</span><span data-bk="start">{{ isset($bk['start']) ? \Carbon\Carbon::parse($bk['start'])->format('d M Y') : now()->addDay()->format('d M Y') }}</span></div>
        @if(!empty($bk['discount']))<div><span>{{ __('Discount') }}</span><span>− AED {{ $bk['discount'] }}</span></div>@endif
        <div style="border:0"><span style="font-weight:800">{{ __('Total') }}</span><span style="font-family:var(--f-display);font-size:30px;color:var(--leaf-800)">AED <span data-bk="total">{{ $bk['total'] ?? 450 }}</span></span></div>
      </div>
    </div>

    <div class="flex wrap" style="justify-content:center;margin-top:30px">
      <a href="{{ route('account.home') }}" class="btn btn-lg">{{ __('Go to my dashboard') }} <span class="arrow">→</span></a>
      <a href="https://wa.me/{{ $b['whatsapp'] }}" class="btn btn-ghost btn-lg" target="_blank" rel="noopener">💬 WhatsApp</a>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
if (window.ARU_STATIC) {
  const mode = new URLSearchParams(location.search).get('mode') || 'paid';
  document.querySelectorAll('[data-when]').forEach(el => el.hidden = !el.dataset.when.split(' ').includes(mode));
  try {
    const b = JSON.parse(sessionStorage.getItem('aru_booking') || 'null');
    if (b) document.querySelectorAll('[data-bk]').forEach(el => { if (b[el.dataset.bk]) el.textContent = el.dataset.bk === 'start' ? new Date(b.start).toLocaleDateString(undefined, { day: '2-digit', month: 'short', year: 'numeric' }) : b[el.dataset.bk]; });
  } catch (_) {}
}
</script>
@if($status !== 'pending')<script>window.addEventListener('load', () => setTimeout(confetti, 300));</script>@endif
@endpush
