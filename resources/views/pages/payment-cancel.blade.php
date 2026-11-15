@extends('layouts.site')
@section('title', __('Payment cancelled'))
@section('content')
<section class="section kolam" style="padding-top:70px">
  <div class="container success-wrap">
    <div class="success-ico" style="background:var(--chilli);box-shadow:0 0 0 14px var(--chilli-100),var(--sh-3)">✕</div>
    <h1 style="font-size:clamp(38px,5vw,60px);color:var(--leaf-950)">{{ __('Payment was cancelled') }}</h1>
    <p class="muted" style="font-size:18px">{{ __('No money was taken. You can try again or contact us on') }} {{ config('arusuvai.brand.support') }}.</p>
    <div class="flex wrap" style="justify-content:center;margin-top:26px">
      <a href="{{ route('book') }}" class="btn btn-spice btn-lg">{{ __('Try again') }} <span class="arrow">→</span></a>
      <a href="{{ route('home') }}" class="btn btn-ghost btn-lg">{{ __('Back to home') }}</a>
    </div>
  </div>
</section>
@endsection
