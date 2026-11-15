@extends('layouts.dash', ['role' => 'customer'])
@section('title', __('Profile'))
@section('page_title', __('Profile'))
@php $c = config('arusuvai.demo_customer'); @endphp

@section('content')
<div class="dgrid g12">
  <div class="dgrid" style="align-content:start">
    <div class="card" style="text-align:center">
      <div style="width:110px;height:110px;border-radius:50%;margin:6px auto 14px;background:linear-gradient(135deg,var(--saffron),var(--chilli));display:grid;place-items:center;color:#fff;font-family:var(--f-display);font-size:40px;font-weight:700;box-shadow:0 0 0 6px var(--turmeric-100)">KR</div>
      <h3 style="font-size:24px">{{ $c['name'] }}</h3>
      <p class="muted" style="margin:4px 0 12px">{{ $c['phone'] }}</p>
      <div class="flex wrap" style="justify-content:center"><span class="pill gold">🏆 {{ $c['tier'] }}</span><span class="pill">✓ {{ __('Verified') }}</span></div>
    </div>
    <div class="card">
      <div class="card-h"><h3>{{ __('Language') }}</h3></div>
      <div class="opts c2">
        @foreach(config('arusuvai.languages') as $code => $l)
          <a href="{{ route('lang', $code) }}" class="opt"><input type="radio" name="lng" {{ app()->getLocale()===$code ? 'checked' : '' }}><div class="box" style="text-align:center"><span class="t">{{ $l['native'] }}</span><span class="s">{{ $l['label'] }}</span></div></a>
        @endforeach
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('Personal details') }}</h3></div>
    <div class="row-2">
      <div class="field"><label>{{ __('Full name') }}</label><input class="input" value="{{ $c['name'] }}"></div>
      <div class="field"><label>🎂 {{ __('Birthday') }}</label><input class="input" type="date" value="{{ $c['birthday'] }}"></div>
    </div>
    <div class="row-2">
      <div class="field"><label>{{ __('Mobile number') }}</label><div class="input-group"><span class="pre">🇦🇪</span><input value="{{ $c['phone'] }}"></div></div>
      <div class="field"><label>{{ __('Email') }}</label><input class="input" value="{{ $c['email'] }}"></div>
    </div>
    <div class="card-h" style="margin-top:12px"><h3>{{ __('Delivery address') }}</h3></div>
    <div class="row-3">
      <div class="field"><label>{{ __('Room no.') }}</label><input class="input" value="{{ $c['room'] }}"></div>
      <div class="field" style="grid-column:span 2"><label>{{ __('Building / Camp name') }}</label><input class="input" value="{{ $c['building'] }}"></div>
    </div>
    <div class="row-3">
      <div class="field"><label>☀️ {{ __('Morning location') }}</label><input class="input" value="{{ __('Same as room') }}"></div>
      <div class="field"><label>🌙 {{ __('Dinner location') }}</label><input class="input" value="{{ __('Same as room') }}"></div>
      <div class="field"><label>📅 {{ __('Sunday location') }}</label><input class="input" value="{{ __('Site office, Block C') }}"></div>
    </div>
    <div class="card-h" style="margin-top:12px"><h3>{{ __('Food preferences') }}</h3></div>
    <div class="flex wrap" style="margin-bottom:22px">
      @foreach([__('Vegetarian'),__('Less spicy'),__('No onion & garlic on Tuesdays'),__('Extra rice'),__('Kerala matta rice')] as $i => $t)
        <label class="chip" style="cursor:pointer"><input type="checkbox" {{ $i % 2 ? '' : 'checked' }} style="accent-color:var(--leaf-700)"> {{ $t }}</label>
      @endforeach
    </div>
    <div class="flex"><button class="btn btn-spice" data-toast="{{ __('Profile saved') }}|{{ __('Your details have been updated.') }}|✅">{{ __('Save changes') }}</button><button class="btn btn-ghost">{{ __('Cancel') }}</button></div>
  </div>
</div>
@endsection
