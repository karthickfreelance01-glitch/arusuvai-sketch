@extends('layouts.site')
@section('title', __('Book Now'))
@php
  $plans = config('arusuvai.plans');
  $schedules = config('arusuvai.schedules');
  $slots = config('arusuvai.meal_slots');
  $selPlan = old('plan', request('plan', 'three'));
  $selPlan = isset($plans[$selPlan]) ? $selPlan : 'three';
  $selSched = old('schedule', request('schedule', 'mon-sun'));
  $selSched = isset($plans[$selPlan]['prices'][$selSched]) ? $selSched : 'mon-sun';
  $stripeLive = (bool) config('arusuvai.stripe.secret');
@endphp

@section('content')
<section class="page-hero kolam" style="padding-bottom:30px">
  <div class="container">
    <div class="crumbs"><a href="{{ route('home') }}">{{ __('Home') }}</a> / {{ __('Service Registration') }}</div>
    <h1>{{ __('Start your meal plan') }}</h1>
    <p>{{ __('Three quick steps. One month payment is made in advance at the time of registration.') }}</p>
  </div>
</section>

<section class="container">
  <form class="wizard" id="wizard" method="POST" action="{{ route('checkout') }}" novalidate>
    @csrf
    <div class="wz-card">
      @if ($errors->any())
        <div class="alert">⚠️ {{ $errors->first() }}</div>
      @endif

      <div class="stepper">
        <div class="s on" data-step-ind="1"><div class="bar"></div><span class="lbl">1 · {{ __('Plan') }}</span></div>
        <div class="s" data-step-ind="2"><div class="bar"></div><span class="lbl">2 · {{ __('Delivery') }}</span></div>
        <div class="s" data-step-ind="3"><div class="bar"></div><span class="lbl">3 · {{ __('Payment') }}</span></div>
      </div>

      {{-- STEP 1 --}}
      <div class="pane on" data-step="1">
        <h2>{{ __('Choose your plan') }}</h2>
        <p class="muted">{{ __('Select how many meals you need each day.') }}</p>
        <div class="opts c3">
          @foreach(['one','two','three'] as $k)
            @php $p = $plans[$k]; @endphp
            <label class="opt">
              <input type="radio" name="plan" value="{{ $k }}" {{ $selPlan === $k ? 'checked' : '' }}>
              <div class="box">
                <span class="em">{{ ['one'=>'🍛','two'=>'🍱','three'=>'🌿'][$k] }}</span>
                <span class="t">{{ __($p['name']) }}</span>
                <span class="s">{{ __($p['subtitle']) }}</span>
                <span class="p">AED {{ min($p['prices']) }}<small style="font-size:13px;color:var(--muted);font-family:var(--f-body)"> {{ __('onwards') }}</small></span>
              </div>
              <span class="tick">✓</span>
            </label>
          @endforeach
        </div>

        <div class="label" style="margin:28px 0 12px">{{ __('Delivery days') }}</div>
        <div class="opts c3" id="sched-opts">
          @foreach($schedules as $key => $s)
            <label class="opt">
              <input type="radio" name="schedule" value="{{ $key }}" {{ $selSched === $key ? 'checked' : '' }}>
              <div class="box"><span class="t">{{ __($s['label']) }}</span><span class="s">{{ $s['days'] }} {{ __('days a week') }}</span><span class="p" data-sched-price="{{ $key }}">—</span></div>
              <span class="tick">✓</span>
            </label>
          @endforeach
        </div>

        <div class="label" style="margin:28px 0 4px">{{ __('Which meals?') }} <span class="muted" id="meal-hint" style="font-weight:600"></span></div>
        <div class="opts c3" id="meal-opts" style="margin-top:10px">
          @foreach($slots as $key => $s)
            <label class="opt">
              <input type="checkbox" name="meals[]" value="{{ $key }}" {{ in_array($key, old('meals', ['lunch'])) ? 'checked' : '' }}>
              <div class="box"><span class="em">{{ $s['icon'] }}</span><span class="t">{{ __($s['label']) }}</span><span class="s">{{ $s['time'] }}</span></div>
              <span class="tick">✓</span>
            </label>
          @endforeach
        </div>

        <div class="row-2" style="margin-top:28px">
          <div>
            <div class="label" style="margin-bottom:10px">{{ __('Cuisine preference') }}</div>
            <div class="opts c3">
              @foreach(['mixed'=>['🍽️','Both'],'tn'=>['🌶️','Tamil Nadu'],'kl'=>['🥥','Kerala']] as $v => $c)
                <label class="opt"><input type="radio" name="cuisine" value="{{ $v }}" {{ old('cuisine','mixed')===$v ? 'checked' : '' }}><div class="box" style="padding:14px;text-align:center"><span class="em">{{ $c[0] }}</span><span class="t" style="font-size:14px">{{ __($c[1]) }}</span></div></label>
              @endforeach
            </div>
          </div>
          <div>
            <div class="label" style="margin-bottom:10px">{{ __('Food type') }}</div>
            <div class="opts c2">
              <label class="opt"><input type="radio" name="food_type" value="veg" checked><div class="box" style="padding:14px;text-align:center"><span class="em">🥗</span><span class="t" style="font-size:14px">{{ __('Vegetarian') }}</span></div></label>
              <label class="opt"><input type="radio" name="food_type" value="nonveg"><div class="box" style="padding:14px;text-align:center"><span class="em">🍗</span><span class="t" style="font-size:14px">{{ __('Non-Veg') }}</span></div></label>
            </div>
          </div>
        </div>

        <div class="wz-nav"><span></span><button type="button" class="btn btn-lg" data-next>{{ __('Continue') }} <span class="arrow">→</span></button></div>
      </div>

      {{-- STEP 2 --}}
      <div class="pane" data-step="2">
        <h2>{{ __('Delivery details') }}</h2>
        <p class="muted">{{ __('Where should we bring your food?') }}</p>
        <div class="row-2">
          <div class="field"><label>{{ __('Full name') }} *</label><input class="input" name="name" value="{{ old('name') }}" required placeholder="{{ __('e.g. Karthik Ramesh') }}"></div>
          <div class="field"><label>{{ __('Start date') }} *</label><input class="input" type="date" name="start_date" value="{{ old('start_date', now()->addDay()->toDateString()) }}" min="{{ now()->addDay()->toDateString() }}" required></div>
        </div>
        <div class="row-2">
          <div class="field"><label>{{ __('Mobile number') }} *</label><div class="input-group"><span class="pre">🇦🇪 +971</span><input name="phone" inputmode="tel" value="{{ old('phone') }}" required placeholder="56 619 9944"></div></div>
          <div class="field"><label>{{ __('WhatsApp number') }}</label><div class="input-group"><span class="pre">💬 +971</span><input name="whatsapp" inputmode="tel" value="{{ old('whatsapp') }}" placeholder="{{ __('Same as mobile') }}"></div></div>
        </div>
        <div class="field"><label>{{ __('Email') }} <span class="hint">({{ __('for your receipt') }})</span></label><input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"></div>
        <div class="row-3">
          <div class="field"><label>{{ __('Room no.') }}</label><input class="input" name="room_no" value="{{ old('room_no') }}" placeholder="214"></div>
          <div class="field" style="grid-column:span 2"><label>{{ __('Building / Camp name') }} *</label><input class="input" name="building" value="{{ old('building') }}" required placeholder="{{ __('e.g. Al Hamra Residence') }}"></div>
        </div>
        <div class="field"><label>{{ __('Area') }}</label>
          <select class="select" name="area">
            @foreach(['Dubai Investment Park 2','Dubai Investment Park 1','Jebel Ali Industrial','Green Community','Other (we will call you)'] as $a)
              <option {{ old('area')===$a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
          </select>
        </div>
        <div class="field"><label>{{ __('Delivery notes') }}</label><textarea class="textarea" name="notes" rows="2" placeholder="{{ __('Gate no., landmark, morning / dinner / Sunday location…') }}">{{ old('notes') }}</textarea></div>
        <div class="wz-nav"><button type="button" class="btn btn-ghost btn-lg" data-prev>← {{ __('Back') }}</button><button type="button" class="btn btn-lg" data-next>{{ __('Continue to payment') }} <span class="arrow">→</span></button></div>
      </div>

      {{-- STEP 3 --}}
      <div class="pane" data-step="3">
        <h2>{{ __('Payment') }}</h2>
        <p class="muted">{{ __('One month payment in advance. You can pay securely online.') }}</p>
        <div class="opts c2">
          <label class="opt"><input type="radio" name="pay_method" value="stripe" checked>
            <div class="box"><div class="flex between"><span class="t">💳 {{ __('Pay online') }}</span></div><span class="s">{{ __('Card, Apple Pay, Google Pay') }}</span><div class="cards-row" style="margin-top:8px"><span>VISA</span><span>Mastercard</span><span>Apple Pay</span><span>G Pay</span></div></div><span class="tick">✓</span></label>
          <label class="opt"><input type="radio" name="pay_method" value="cash">
            <div class="box"><span class="t">🏪 {{ __('Pay at office / Cash') }}</span><span class="s">{{ __('Our team will call to confirm. Plan starts after payment.') }}</span></div><span class="tick">✓</span></label>
        </div>

        <div class="pay-card" style="margin-top:22px">
          <div class="flex between wrap"><span class="stripe-badge">stripe</span><span class="pill {{ $stripeLive ? '' : 'gold' }}"><span class="dot"></span> {{ $stripeLive ? __('Secure checkout') : __('Demo mode — add Stripe keys in .env') }}</span></div>
          <p class="muted" style="margin:14px 0 0;font-size:14px">🔒 {{ __('You will be redirected to Stripe\'s secure payment page. We never see or store your card details.') }}</p>
        </div>

        <div class="field" style="margin-top:22px"><label>{{ __('Coupon code') }}</label>
          <div class="input-group"><span class="pre">🎁</span><input name="coupon" id="coupon" value="{{ old('coupon', request('coupon')) }}" placeholder="WELCOME10"><button type="button" class="btn btn-sm" id="apply-coupon" style="margin:6px;border-radius:10px">{{ __('Apply') }}</button></div>
        </div>
        <label class="check"><input type="checkbox" id="agree" checked> <span>{{ __('I agree to the meal plan terms and the early stopping policy (inform 1 day in advance).') }}</span></label>

        <div class="wz-nav"><button type="button" class="btn btn-ghost btn-lg" data-prev>← {{ __('Back') }}</button><button type="submit" class="btn btn-spice btn-lg" id="pay-btn">🔒 {{ __('Pay') }} AED <span data-total>0</span></button></div>
      </div>
    </div>

    {{-- SUMMARY --}}
    <aside class="summary">
      <span class="eyebrow" style="color:var(--turmeric)">{{ __('Your order') }}</span>
      <h3 style="margin-top:10px" id="s-plan">—</h3>
      <div class="line"><span>{{ __('Days') }}</span><span id="s-sched">—</span></div>
      <div class="line"><span>{{ __('Meals') }}</span><span id="s-meals">—</span></div>
      <div class="line"><span>{{ __('Duration') }}</span><span>30 {{ __('days') }}</span></div>
      <div class="line"><span>{{ __('Start date') }}</span><span id="s-start">—</span></div>
      <div class="line"><span>{{ __('Subtotal') }}</span><span>AED <span id="s-sub">0</span></span></div>
      <div class="line" id="s-disc-row" style="display:none"><span>{{ __('Discount') }} <span id="s-code">{{ old('coupon', request('coupon')) ? '('.strtoupper(old('coupon', request('coupon'))).')' : '' }}</span></span><span style="color:var(--turmeric)">− AED <span id="s-disc">0</span></span></div>
      <div class="total"><span style="font-weight:700">{{ __('Total today') }}</span><b>AED <span data-total>0</span></b></div>
      <div class="secure">🔒 {{ __('Secured by Stripe · 256-bit SSL') }}</div>
      <div class="secure">🏆 {{ __('You will earn') }} <b style="color:#fff" id="s-pts">0</b> {{ __('reward points') }}</div>
    </aside>
  </form>
</section>
@endsection

@push('scripts')
@php $jsT = ['pick' => __('pick'), 'notAvail' => __('Not available'), 'need' => __('Please select exactly'), 'meals' => __('meals'), 'meal' => __('meal'), 'required' => __('Please fill the required fields'), 'coupon' => __('Coupon applied!'), 'couponMsg' => __('10% off your first month'), 'bad' => __('Invalid coupon'), 'redir' => __('Redirecting to secure payment…')]; @endphp
<script>
(() => {
  const plans = @json($plans), schedules = @json($schedules), coupons = @json(config('arusuvai.coupons'));
  const T = @json($jsT);
  const f = document.getElementById('wizard');
  let step = 1, coupon = coupons[(f.coupon.value || '').trim().toUpperCase()] || null;
  const val = n => (f.querySelector(`[name="${n}"]:checked`) || {}).value;

  function sync() {
    const k = val('plan'), p = plans[k];
    // schedule availability + prices
    document.querySelectorAll('#sched-opts input').forEach(i => {
      const price = p.prices[i.value];
      i.disabled = !price;
      document.querySelector(`[data-sched-price="${i.value}"]`).textContent = price ? 'AED ' + price : T.notAvail;
    });
    if (f.querySelector('[name=schedule]:checked').disabled) f.querySelector('[name=schedule][value="mon-sun"]').checked = true;
    // meals
    const boxes = [...document.querySelectorAll('#meal-opts input')];
    if (p.meals === 3) boxes.forEach(b => { b.checked = true; });
    let checked = boxes.filter(b => b.checked);
    while (checked.length > p.meals) { checked[0].checked = false; checked = boxes.filter(b => b.checked); }
    document.getElementById('meal-hint').textContent = `(${T.pick} ${p.meals} ${p.meals > 1 ? T.meals : T.meal})`;

    const sched = val('schedule'), sub = p.prices[sched], disc = !coupon ? 0 : (coupon.type === 'percent' ? Math.round(sub * coupon.value / 100) : Math.min(sub, coupon.value)), total = sub - disc;
    document.getElementById('s-plan').textContent = p.name;
    document.getElementById('s-sched').textContent = schedules[sched].label;
    document.getElementById('s-meals').textContent = checked.map(c => c.closest('.opt').querySelector('.t').textContent).join(' + ') || '—';
    document.getElementById('s-start').textContent = f.start_date.value ? new Date(f.start_date.value).toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric' }) : '—';
    document.getElementById('s-sub').textContent = sub;
    document.getElementById('s-disc').textContent = disc;
    document.getElementById('s-disc-row').style.display = disc ? 'flex' : 'none';
    document.querySelectorAll('[data-total]').forEach(e => e.textContent = total);
    document.getElementById('s-pts').textContent = total * (p.meals === 3 ? 2 : 1);
  }

  // Limit meal checkboxes to plan count
  document.querySelectorAll('#meal-opts input').forEach(b => b.addEventListener('change', () => {
    const p = plans[val('plan')]; const boxes = [...document.querySelectorAll('#meal-opts input')];
    if (p.meals === 3) { b.checked = true; }
    const on = boxes.filter(x => x.checked);
    if (on.length > p.meals) on.find(x => x !== b).checked = false;
    sync();
  }));
  f.addEventListener('change', sync); f.addEventListener('input', e => { if (e.target.name === 'start_date') sync(); });

  function go(n) {
    step = n;
    document.querySelectorAll('[data-step]').forEach(p => p.classList.toggle('on', +p.dataset.step === n));
    document.querySelectorAll('[data-step-ind]').forEach(s => { const i = +s.dataset.stepInd; s.classList.toggle('on', i === n); s.classList.toggle('done', i < n); });
    window.scrollTo({ top: f.getBoundingClientRect().top + scrollY - 110, behavior: 'smooth' });
  }
  function validate(n) {
    if (n === 1) {
      const p = plans[val('plan')], c = document.querySelectorAll('#meal-opts input:checked').length;
      if (c !== p.meals) { toast(T.need + ' ' + p.meals + ' ' + (p.meals > 1 ? T.meals : T.meal), '', '⚠️'); return false; }
    }
    if (n === 2) {
      const bad = ['name', 'phone', 'building', 'start_date'].map(k => f[k]).filter(i => !i.value.trim());
      document.querySelectorAll('[data-step="2"] .input, [data-step="2"] .input-group').forEach(el => el.style.borderColor = '');
      bad.forEach(i => (i.closest('.input-group') || i).style.borderColor = 'var(--chilli)');
      if (bad.length) { toast(T.required, '', '⚠️'); bad[0].focus(); return false; }
    }
    return true;
  }
  f.querySelectorAll('[data-next]').forEach(b => b.addEventListener('click', () => validate(step) && go(step + 1)));
  f.querySelectorAll('[data-prev]').forEach(b => b.addEventListener('click', () => go(step - 1)));

  document.getElementById('apply-coupon').addEventListener('click', () => {
    coupon = coupons[f.coupon.value.trim().toUpperCase()] || null;
    document.getElementById('s-code').textContent = coupon ? '(' + f.coupon.value.trim().toUpperCase() + ')' : '';
    coupon ? (toast(T.coupon, coupon.label, '🎉'), confetti()) : toast(T.bad, 'Try WELCOME10', '⚠️');
    sync();
  });
  f.addEventListener('submit', e => {
    if (!validate(1) || !validate(2)) { e.preventDefault(); return; }
    if (!document.getElementById('agree').checked) { e.preventDefault(); toast('⚠️', T.required, '⚠️'); return; }
    const btn = document.getElementById('pay-btn'); btn.disabled = true; btn.innerHTML = '⏳ ' + T.redir;

    // Static hosting: no server, so go to a Stripe Payment Link (or demo success page)
    if (window.ARU_STATIC) {
      e.preventDefault();
      const k = val('plan'), sched = val('schedule'), p = plans[k], sub = p.prices[sched];
      const disc = !coupon ? 0 : (coupon.type === 'percent' ? Math.round(sub * coupon.value / 100) : Math.min(sub, coupon.value));
      const ref = 'ARU-' + Math.random().toString(16).slice(2, 10).toUpperCase();
      const booking = { reference: ref, plan: p.name, schedule: schedules[sched].label, start: f.start_date.value, total: sub - disc, discount: disc,
        meals: [...document.querySelectorAll('#meal-opts input:checked')].map(c => c.value).join(', '), name: f.name.value, phone: f.phone.value };
      try { sessionStorage.setItem('aru_booking', JSON.stringify(booking)); } catch (_) {}
      const link = ARU_STATIC.links[k + '.' + sched];
      const method = val('pay_method');
      if (method === 'stripe' && link) {
        const u = new URL(link); u.searchParams.set('client_reference_id', ref);
        if (f.email.value) u.searchParams.set('prefilled_email', f.email.value);
        location.href = u.toString();
      } else {
        location.href = ARU_STATIC.base + '/payment/success/?mode=' + (method === 'cash' ? 'cash' : 'demo');
      }
    }
  });

  // Pre-select from the URL (needed on the static site)
  const qs = new URLSearchParams(location.search);
  if (qs.get('plan') && plans[qs.get('plan')]) f.querySelector(`[name=plan][value="${qs.get('plan')}"]`).checked = true;
  if (qs.get('schedule')) { const r = f.querySelector(`[name=schedule][value="${qs.get('schedule')}"]`); if (r && plans[val('plan')].prices[qs.get('schedule')]) r.checked = true; }
  if (qs.get('coupon')) { f.coupon.value = qs.get('coupon'); coupon = coupons[qs.get('coupon').toUpperCase()] || null; document.getElementById('s-code').textContent = coupon ? '(' + qs.get('coupon').toUpperCase() + ')' : ''; }
  sync();
  @if ($errors->any()) go(3); @endif
})();
</script>
@endpush
