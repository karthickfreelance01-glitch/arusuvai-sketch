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
      <span class="eyebrow">{{ $status === 'cash' ? __('Registration received') : __('Payment successful') }}</span>
      <h1 style="font-size:clamp(38px,5vw,64px);color:var(--leaf-950);margin-top:12px">{{ __('Welcome to the Arusuvai family!') }}</h1>
      <p class="muted" style="font-size:18px">
        @if($status === 'cash') {{ __('Our team will call you to collect the payment and confirm your start date.') }}
        @else {{ __('Your 30 days meal plan is confirmed. A receipt has been sent to your WhatsApp and email.') }} @endif
      </p>
      @if($status === 'demo')<span class="pill gold" style="margin-top:6px">🧪 {{ __('Demo mode — no real payment was taken') }}</span>@endif
    @endif

    <div class="receipt">
      <div class="flex between wrap" style="margin-bottom:14px">
        <div><small class="muted" style="font-weight:700">{{ __('Booking reference') }}</small><div style="font-family:var(--f-display);font-size:28px;font-weight:700">{{ $bk['reference'] ?? 'ARU-DEMO' }}</div></div>
        <span class="pill"><span class="dot"></span> {{ $status === 'cash' ? __('Awaiting payment') : __('Active') }}</span>
      </div>
      <div class="calc-rows">
        <div><span>{{ __('Plan') }}</span><span>{{ $bk['plan'] ?? '3 Meals Plan' }}</span></div>
        <div><span>{{ __('Days') }}</span><span>{{ $bk['schedule'] ?? 'Monday – Sunday' }}</span></div>
        @if(!empty($bk['meals']))<div><span>{{ __('Meals') }}</span><span>{{ $bk['meals'] }}</span></div>@endif
        <div><span>{{ __('Start date') }}</span><span>{{ isset($bk['start']) ? \Carbon\Carbon::parse($bk['start'])->format('d M Y') : now()->addDay()->format('d M Y') }}</span></div>
        @if(!empty($bk['discount']))<div><span>{{ __('Discount') }}</span><span>− AED {{ $bk['discount'] }}</span></div>@endif
        <div style="border:0"><span style="font-weight:800">{{ __('Total') }}</span><span style="font-family:var(--f-display);font-size:30px;color:var(--leaf-800)">AED {{ $bk['total'] ?? 450 }}</span></div>
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
@if($status !== 'pending')<script>window.addEventListener('load', () => setTimeout(confetti, 300));</script>@endif
@endpush
