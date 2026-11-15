@extends('layouts.site')
@section('title', __('Meal Change'))
@php $c = config('arusuvai.demo_customer'); $plans = config('arusuvai.plans'); $slots = config('arusuvai.meal_slots'); @endphp

@section('content')
<section class="page-hero kolam" style="padding-bottom:30px">
  <div class="container">
    <div class="crumbs"><a href="{{ route('home') }}">{{ __('Home') }}</a> / {{ __('Meal Change') }}</div>
    <h1>{{ __('Change a meal') }} 🔄</h1>
    <p>{{ __('Swap a dish, change your delivery location or skip a day. Please inform us 1 day in advance.') }}</p>
  </div>
</section>

<section class="container-sm">
  <div class="wz-card">
    {{-- Find subscription --}}
    <div id="mc-find">
      <h2 style="font-size:30px;color:var(--leaf-950)">{{ __('Find your subscription') }}</h2>
      <p class="muted">{{ __('Enter the mobile number you registered with.') }}</p>
      <div class="flex wrap" style="align-items:stretch">
        <div class="input-group" style="flex:1;min-width:240px"><span class="pre">🇦🇪 +971</span><input id="mc-phone" inputmode="tel" placeholder="56 619 9944" value="56 619 9944"></div>
        <button class="btn btn-lg" id="mc-search" type="button">{{ __('Search') }} <span class="arrow">→</span></button>
      </div>
    </div>

    <div id="mc-form" style="display:none;margin-top:30px">
      <div class="card" style="background:var(--leaf-50);border-color:var(--leaf-100);display:flex;gap:16px;align-items:center;flex-wrap:wrap">
        <div class="who"><span class="av" style="background:linear-gradient(135deg,var(--saffron),var(--chilli));width:52px;height:52px;flex-basis:52px">KR</span><div><b style="font-size:18px">{{ $c['name'] }}</b><small>{{ $c['room'] }}, {{ $c['building'] }}</small></div></div>
        <div style="margin-left:auto" class="flex wrap"><span class="pill">✓ {{ __($plans[$c['plan']]['name']) }}</span><span class="pill gold">{{ __('Valid till') }} {{ \Carbon\Carbon::parse($c['end'])->format('d M') }}</span></div>
      </div>

      <div class="label" style="margin:28px 0 12px">{{ __('What would you like to do?') }}</div>
      <div class="opts c3">
        <label class="opt"><input type="radio" name="mc-type" value="swap" checked><div class="box"><span class="em">🍛</span><span class="t">{{ __('Swap a meal') }}</span><span class="s">{{ __('Choose another dish') }}</span></div><span class="tick">✓</span></label>
        <label class="opt"><input type="radio" name="mc-type" value="loc"><div class="box"><span class="em">📍</span><span class="t">{{ __('Change location') }}</span><span class="s">{{ __('Deliver somewhere else') }}</span></div><span class="tick">✓</span></label>
        <label class="opt"><input type="radio" name="mc-type" value="skip"><div class="box"><span class="em">⏸️</span><span class="t">{{ __('Skip / pause') }}</span><span class="s">{{ __('Leave or travel day') }}</span></div><span class="tick">✓</span></label>
      </div>

      <div class="label" style="margin:28px 0 12px">{{ __('Date') }}</div>
      <div class="day-tabs" id="mc-dates">
        @for($i = 1; $i <= 7; $i++)
          @php $d = now()->addDays($i); @endphp
          <button type="button" class="day-tab {{ $i===1 ? 'on' : '' }}" data-date="{{ $d->toDateString() }}"><small>{{ __($d->format('D')) }}</small><b>{{ $d->format('d') }}</b><small style="letter-spacing:0">{{ __($d->format('M')) }}</small></button>
        @endfor
      </div>

      <div class="label" style="margin:10px 0 12px">{{ __('Meal') }}</div>
      <div class="opts c3">
        @foreach($slots as $k => $s)
          <label class="opt"><input type="radio" name="mc-slot" value="{{ $k }}" {{ $k==='lunch' ? 'checked' : '' }}><div class="box" style="text-align:center"><span class="em">{{ $s['icon'] }}</span><span class="t">{{ __($s['label']) }}</span></div></label>
        @endforeach
      </div>

      <div data-mc="swap" style="margin-top:26px">
        <div class="label" style="margin-bottom:12px">{{ __('Choose your replacement') }}</div>
        <div class="opts c3">
          @foreach([['d-rice.jpg','Veg Pulao & Raita'],['s-rice.jpg','Kerala Meals'],['d-curry.jpg','Chapati & Kurma'],['d-dosa.jpg','Masala Dosa'],['d-plainrice.jpg','Curd Rice & Pickle'],['s-dal.jpg','Dal Fry & Rice']] as $i => $o)
            <label class="opt"><input type="radio" name="mc-dish" value="{{ $o[1] }}" {{ $i===0 ? 'checked' : '' }}><div class="box" style="padding:10px"><img src="{{ asset('assets/img/'.$o[0]) }}" alt="" style="border-radius:12px;aspect-ratio:16/10;object-fit:cover;width:100%"><span class="t" style="font-size:14.5px;margin-top:4px">{{ $o[1] }}</span></div><span class="tick">✓</span></label>
          @endforeach
        </div>
      </div>
      <div data-mc="loc" style="display:none;margin-top:26px">
        <div class="row-2">
          <div class="field"><label>{{ __('Building / Camp name') }}</label><input class="input" placeholder="{{ __('e.g. Site office, Block C') }}"></div>
          <div class="field"><label>{{ __('Room no.') }}</label><input class="input" placeholder="—"></div>
        </div>
      </div>
      <div data-mc="skip" style="display:none;margin-top:26px">
        <div class="alert ok">ℹ️ {{ __('Skipped meals are adjusted as per the early stopping policy. Our team will confirm on WhatsApp.') }}</div>
      </div>

      <div class="field" style="margin-top:20px"><label>{{ __('Note for the kitchen') }}</label><textarea class="textarea" rows="2" placeholder="{{ __('Less spicy, extra rice…') }}"></textarea></div>
      <button class="btn btn-spice btn-lg btn-block" id="mc-submit" type="button">{{ __('Submit change request') }} <span class="arrow">→</span></button>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
  const find = document.getElementById('mc-search');
  find.addEventListener('click', () => {
    find.innerHTML = '⏳'; setTimeout(() => {
      find.innerHTML = '✓'; document.getElementById('mc-form').style.display = 'block';
      document.getElementById('mc-form').animate([{ opacity: 0, transform: 'translateY(16px)' }, { opacity: 1, transform: 'none' }], { duration: 450, easing: 'ease-out' });
    }, 600);
  });
  document.querySelectorAll('[name=mc-type]').forEach(r => r.addEventListener('change', () => {
    document.querySelectorAll('[data-mc]').forEach(el => el.style.display = el.dataset.mc === r.value ? 'block' : 'none');
  }));
  const tabs = document.querySelectorAll('#mc-dates .day-tab');
  tabs.forEach(t => t.addEventListener('click', () => { tabs.forEach(x => x.classList.remove('on')); t.classList.add('on'); }));
  document.getElementById('mc-submit').addEventListener('click', () => {
    toast(@json(__('Request sent!')), @json(__('We will confirm your change on WhatsApp shortly.')), '✅'); confetti();
  });
})();
</script>
@endpush
