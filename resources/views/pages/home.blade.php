@extends('layouts.site')
@section('title', __('30 Days Meal Plan'))

@php
  $b = config('arusuvai.brand');
  $plans = config('arusuvai.plans');
  $schedules = config('arusuvai.schedules');
  $menu = config('arusuvai.menu');
  $slots = config('arusuvai.meal_slots');
  $today = now()->format('l');
@endphp

@section('content')
{{-- ============ HERO ============ --}}
<section class="hero kolam">
  <div class="container">
    <div>
      <span class="chip reveal">🍃 {{ __('Tamil Nadu & Kerala home food') }} · {{ $b['location'] }}</span>
      <h1 class="reveal d1">{{ __('Homely food,') }}<br><em>{{ __('every single') }}</em> <span class="under">{{ __('day.') }}<svg viewBox="0 0 200 18" preserveAspectRatio="none"><path d="M2 12 C 50 2, 120 2, 198 10" stroke="#f4b41a" stroke-width="6" fill="none" stroke-linecap="round"/></svg></span></h1>
      <p class="lead reveal d2">{{ __('Our 30 Days Meal Plan brings affordable, fresh and homely breakfast, lunch and dinner to your door — cooked the traditional way, every morning.') }}</p>
      <div class="hero-cta reveal d3">
        <a href="{{ route('book') }}" class="btn btn-spice btn-lg">{{ __('Start my meal plan') }} <span class="arrow">→</span></a>
        <a href="#plans" class="btn btn-ghost btn-lg">{{ __('See prices') }}</a>
      </div>
      <div class="hero-proof reveal d4">
        <div class="avatars">
          <span style="background:#c73a1d">SK</span><span style="background:#17603a">AM</span><span style="background:#ee7a1b">RJ</span><span style="background:#2b78c4">+</span>
        </div>
        <div class="stat"><b data-count="1200" data-suffix="+">0</b><span>{{ __('Happy subscribers') }}</span></div>
        <div class="stat"><b data-count="98" data-suffix="%">0</b><span>{{ __('On-time delivery') }}</span></div>
        <div class="stat"><b>4.9<span style="font-size:20px;color:var(--turmeric-600)">★</span></b><span>{{ __('Average rating') }}</span></div>
      </div>
    </div>

    <div class="hero-visual reveal d2">
      <div class="leaf-under"></div>
      <div class="plate"><img src="{{ asset('assets/img/dosa.jpg') }}" alt="Dosa thali"></div>
      <div class="price-burst"><div><small>{{ __('from') }}</small><b>220</b><small>AED / {{ __('month') }}</small></div></div>
      <div class="orbit o1"><img src="{{ asset('assets/img/s-payasam.jpg') }}" alt=""><div>{{ __('Sunday Sadya') }}<small>{{ __('with payasam') }}</small></div></div>
      <div class="orbit o2"><img src="{{ asset('assets/img/d-sambar.jpg') }}" alt=""><div>{{ __('Hot sambar') }}<small>{{ __('cooked fresh daily') }}</small></div></div>
      <div class="orbit o3"><span style="width:44px;height:44px;border-radius:50%;display:grid;place-items:center;background:var(--leaf-100);font-size:22px">🛵</span><div>{{ __('Out for delivery') }}<small>{{ __('Arriving in 12 min') }}</small></div></div>
    </div>
  </div>
</section>

{{-- ============ MARQUEE ============ --}}
@php $mq = [['d-dosa.jpg','Ghee Roast Dosa'],['s-avial.jpg','Avial'],['d-sambar.jpg','Sambar'],['s-payasam.jpg','Payasam'],['d-curry.jpg','Veg Kurma'],['s-rice.jpg','Kerala Matta Rice'],['d-rice.jpg','Veg Pulao'],['s-chips.jpg','Banana Chips'],['s-rasam.jpg','Rasam'],['d-poriyal.jpg','Poriyal']]; @endphp
<div class="marquee-wrap"><div class="marquee" aria-hidden="true">
  <div class="marquee-track">
    @foreach(array_merge($mq, $mq) as $m)
      <div class="marquee-item"><img src="{{ asset('assets/img/'.$m[0]) }}" alt="">{{ $m[1] }} <span class="star">✦</span></div>
    @endforeach
  </div>
</div></div>

{{-- ============ PLANS ============ --}}
<section class="section" id="plans">
  <div class="container">
    <div class="section-head center reveal">
      <span class="eyebrow">{{ __('30 Days Meal Plan') }}</span>
      <h2>{{ __('Pick a plan that fits your week') }}</h2>
      <p>{{ __('One month payment in advance. Choose the days you need — we cook, pack and deliver.') }}</p>
      <div class="seg" id="sched-seg" style="margin-top:14px">
        <span class="thumb"></span>
        @foreach($schedules as $key => $s)
          <button type="button" data-value="{{ $key }}" class="{{ $loop->first ? 'on' : '' }}">{{ __($s['label']) }}</button>
        @endforeach
      </div>
    </div>

    <div class="plans">
      @foreach(['one','three','two'] as $k)
        @php $p = $plans[$k]; $ico = ['one'=>['🍛','var(--sky-100)'],'two'=>['🍱','var(--leaf-100)'],'three'=>['🌿','rgba(244,180,26,.2)']][$k]; @endphp
        <article class="plan {{ $k === 'three' ? 'featured' : '' }} reveal d{{ $loop->iteration }}" data-plan="{{ $k }}">
          <span class="pill {{ $k==='three' ? 'gold' : ($k==='two' ? '' : 'sky') }} tag">{{ __($p['badge']) }}</span>
          <div class="icon" style="background:{{ $ico[1] }}">{{ $ico[0] }}</div>
          <h3>{{ __($p['name']) }}</h3>
          <div class="sub">{{ __($p['subtitle']) }}</div>
          <div class="price"><span class="cur">AED</span><span class="amt">{{ reset($p['prices']) }}</span></div>
          <div class="per" data-per>{{ __('per month') }} · <b>{{ __('Early stop') }}: AED {{ $p['early_stop'] }}/{{ __('day') }}</b></div>
          <ul>@foreach($p['perks'] as $perk)<li>{{ __($perk) }}</li>@endforeach</ul>
          <a href="{{ route('book') }}?plan={{ $k }}" class="btn {{ $k==='three' ? 'btn-gold' : 'btn-ghost' }} btn-block" data-book>{{ __('Choose this plan') }} <span class="arrow">→</span></a>
        </article>
      @endforeach
    </div>
    <div class="plans-note reveal">
      <span>💳 {{ __('Pay securely by card, Apple Pay or Google Pay') }}</span>
      <span>🔄 {{ __('Change your meal any time') }}</span>
      <span>⏸️ {{ __('Early stop with 1 day notice') }}</span>
    </div>
  </div>
</section>

{{-- ============ HOW IT WORKS ============ --}}
<section class="section bg-leaf kolam" style="background-color:var(--leaf-900)">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow" style="color:var(--turmeric)">{{ __('How it works') }}</span>
      <h2>{{ __('From our kitchen to your room in four easy steps') }}</h2>
    </div>
    <div class="steps">
      <div class="step reveal d1"><span class="ico">📝</span><h3>{{ __('Register') }}</h3><p>{{ __('Sign up with your mobile number or email in under a minute.') }}</p></div>
      <div class="step reveal d2"><span class="ico">🍽️</span><h3>{{ __('Choose your plan') }}</h3><p>{{ __('Pick 1, 2 or 3 meals and the days of the week you need.') }}</p></div>
      <div class="step reveal d3"><span class="ico">💳</span><h3>{{ __('Pay online') }}</h3><p>{{ __('Pay the month in advance securely with Stripe.') }}</p></div>
      <div class="step reveal d4"><span class="ico">🛵</span><h3>{{ __('Track & enjoy') }}</h3><p>{{ __('Get live delivery updates and earn rewards with every meal.') }}</p></div>
    </div>
  </div>
</section>

{{-- ============ MENU PREVIEW ============ --}}
<section class="section">
  <div class="container">
    <div class="flex between wrap" style="align-items:flex-end;margin-bottom:34px">
      <div class="section-head reveal" style="margin:0">
        <span class="eyebrow">{{ __('This week\'s menu') }}</span>
        <h2>{{ __('A different taste every day') }}</h2>
      </div>
      <a href="{{ route('menu') }}" class="btn btn-ghost reveal">{{ __('Full weekly menu') }} <span class="arrow">→</span></a>
    </div>
    <div class="day-tabs reveal" id="day-tabs">
      @foreach($menu as $day => $meals)
        <button type="button" class="day-tab {{ $day === $today ? 'on' : '' }}" data-day="{{ $day }}"><small>{{ __(substr($day,0,3)) }}</small><b>{{ __($day) }}</b></button>
      @endforeach
    </div>
    <div class="meal-cards" id="meal-cards"></div>
  </div>
</section>

{{-- ============ FEATURES BENTO ============ --}}
<section class="section bg-paper">
  <div class="container">
    <div class="section-head center reveal">
      <span class="eyebrow">{{ __('More than a mess') }}</span>
      <h2>{{ __('Everything you need, in one simple app') }}</h2>
    </div>
    <div class="bento">
      <div class="tile t-a reveal">
        <div class="ico" style="background:rgba(255,255,255,.1)">📍</div>
        <h3>{{ __('Live delivery tracking') }}</h3>
        <p>{{ __('See when your food is cooked, packed and on the way. Know exactly when to step out of your room.') }}</p>
        <a href="{{ route('account.track') }}" class="btn btn-gold" style="margin-top:22px">{{ __('Try the tracker') }} <span class="arrow">→</span></a>
        <div class="track-mini">
          <div class="map">
            <svg viewBox="0 0 400 170" width="100%" height="100%"><path d="M0 120 H400 M0 60 H400 M90 0 V170 M250 0 V170" stroke="#fff" stroke-width="14"/><path d="M40 140 C 120 140, 120 60, 200 60 S 300 30, 350 40" stroke="#ee7a1b" stroke-width="4" fill="none" stroke-dasharray="8 8"/><circle cx="40" cy="140" r="9" fill="#17603a"/><circle cx="350" cy="40" r="9" fill="#c73a1d"/><circle cx="200" cy="60" r="14" fill="#ee7a1b"/><text x="193" y="66" font-size="14">🛵</text></svg>
          </div>
          <div class="row"><div><small class="muted" style="font-weight:700">{{ __('Arriving in') }}</small><div class="eta">12 min</div></div><span class="pill"><span class="dot"></span> {{ __('On the way') }}</span></div>
        </div>
      </div>
      <div class="tile t-b reveal d1">
        <div class="ico" style="background:rgba(255,255,255,.4)">🏆</div>
        <h3>{{ __('Rewards') }}</h3>
        <p>{{ __('Earn points on every meal, refer friends and redeem free meals.') }}</p>
      </div>
      <div class="tile t-c reveal d2">
        <div class="ico" style="background:rgba(255,255,255,.15)">🎂</div>
        <h3>{{ __('Birthday treat') }}</h3>
        <p>{{ __('A special sweet and 20% off on your birthday month — on us.') }}</p>
      </div>
      <div class="tile t-d reveal">
        <div class="ico">🗣️</div>
        <h3>{{ __('Your language') }}</h3>
        <p>{{ __('Use the app in the language you are most comfortable with.') }}</p>
        <div class="lang-pills"><span>English</span><span>தமிழ்</span><span>മലയാളം</span><span>हिन्दी</span></div>
      </div>
      <div class="tile t-e reveal d1">
        <div class="ico" style="background:var(--turmeric-100)">🔔</div>
        <h3>{{ __('Smart notifications') }}</h3>
        <p>{{ __('WhatsApp, SMS and app alerts for delivery, renewal and offers.') }}</p>
      </div>
      <div class="tile t-f reveal d2">
        <div class="ico" style="background:var(--chilli-100)">🔄</div>
        <h3>{{ __('Flexible plans') }}</h3>
        <p>{{ __('Change meals, pause on leave days, or stop early with 1 day notice.') }}</p>
      </div>
    </div>
  </div>
</section>

{{-- ============ EARLY STOP CALCULATOR ============ --}}
<section class="section">
  <div class="container-sm">
    <div class="section-head center reveal">
      <span class="eyebrow">{{ __('Early Stopping Policy') }}</span>
      <h2>{{ __('Need to stop early? It\'s fair and simple.') }}</h2>
      <p>{{ __('Inform us 1 day in advance. Days you used are charged at the per-day rate and the balance is returned to you.') }}</p>
    </div>
    <div class="calc reveal">
      <div class="l">
        <div class="label" style="margin-bottom:10px">{{ __('Your plan') }}</div>
        <div class="opts c3" style="margin-bottom:26px">
          @foreach(['one','two','three'] as $k)
            <label class="opt"><input type="radio" name="calc-plan" value="{{ $k }}" {{ $k==='three' ? 'checked' : '' }}><div class="box"><span class="t">{{ $plans[$k]['meals'] }} {{ $plans[$k]['meals'] > 1 ? __('Meals') : __('Meal') }}</span><span class="s">AED {{ $plans[$k]['early_stop'] }}/{{ __('day') }}</span></div></label>
          @endforeach
        </div>
        <div class="flex between"><span class="label">{{ __('Days used before stopping') }}</span><b id="calc-days-lbl" style="font-family:var(--f-display);font-size:26px">10</b></div>
        <input type="range" class="range" id="calc-days" min="1" max="29" value="10" style="margin-top:14px">
        <div class="flex between muted" style="font-size:12px;font-weight:700;margin-top:6px"><span>1</span><span>29</span></div>
      </div>
      <div class="r">
        <span class="muted" style="font-weight:700">{{ __('Estimated refund') }}</span>
        <div class="big-num">AED <span id="calc-refund">0</span></div>
        <div class="calc-rows">
          <div><span>{{ __('Monthly plan (Mon–Sun)') }}</span><span id="calc-paid">0</span></div>
          <div><span>{{ __('Used days × per-day rate') }}</span><span id="calc-used">0</span></div>
        </div>
        <p class="muted" style="font-size:13px;margin-top:16px">{{ __('Applies within the 30 days subscription. Final amount confirmed by our team.') }}</p>
      </div>
    </div>
  </div>
</section>

{{-- ============ TESTIMONIALS ============ --}}
<section class="section bg-paper">
  <div class="container">
    <div class="section-head center reveal">
      <span class="eyebrow">{{ __('Loved in DIP 2') }}</span>
      <h2>{{ __('Tastes like home, they say') }}</h2>
    </div>
    <div class="quotes">
      <div class="quote reveal d1"><div class="stars">★★★★★</div><p>“{{ __('The sambar and poriyal taste exactly like my amma\'s cooking. Delivery is always on time before my shift.') }}”</p><div class="who"><span style="background:#c73a1d">SK</span><div><b>Senthil Kumar</b><br><small class="muted">{{ __('3 Meals Plan · 8 months') }}</small></div></div></div>
      <div class="quote reveal d2"><div class="stars">★★★★★</div><p>“{{ __('Sunday sadya is the highlight of my week! Very clean packing and the price is very fair.') }}”</p><div class="who"><span style="background:#17603a">AM</span><div><b>Anoop Menon</b><br><small class="muted">{{ __('2 Meals Plan · 1 year') }}</small></div></div></div>
      <div class="quote reveal d3"><div class="stars">★★★★★</div><p>“{{ __('I can change my meal from my phone and track the delivery. Very professional service.') }}”</p><div class="who"><span style="background:#ee7a1b">RJ</span><div><b>Rahul Joshi</b><br><small class="muted">{{ __('1 Meal Plan · 4 months') }}</small></div></div></div>
    </div>
  </div>
</section>

{{-- ============ FAQ ============ --}}
<section class="section">
  <div class="container-sm">
    <div class="section-head center reveal"><span class="eyebrow">FAQ</span><h2>{{ __('Questions? We have answers.') }}</h2></div>
    <div class="faq reveal">
      <details open><summary>{{ __('How do I pay for my plan?') }}</summary><p>{{ __('One month payment should be made in advance at the time of registration. Pay online by card, Apple Pay or Google Pay through our secure Stripe checkout, or contact us on 0566199944.') }}</p></details>
      <details><summary>{{ __('Which areas do you deliver to?') }}</summary><p>{{ __('We deliver across Dubai Investment Park 2 and nearby camps and residences. For delivery enquiries call 0522047689.') }}</p></details>
      <details><summary>{{ __('Can I change my meal?') }}</summary><p>{{ __('Yes. Use the Meal Change page or your dashboard to swap a meal or change the delivery location for the next day.') }}</p></details>
      <details><summary>{{ __('What if I want to stop early?') }}</summary><p>{{ __('Inform us 1 day in advance. Used days are charged at AED 8 / 13 / 17 per day for 1 / 2 / 3 meals, within the 30 days subscription.') }}</p></details>
    </div>
  </div>
</section>

{{-- ============ CTA ============ --}}
<section class="container">
  <div class="cta-band reveal">
    <div>
      <h2>{{ __('Ready for real home food?') }}</h2>
      <p>{{ __('Tell us your preferred meal plan and starting date. We look forward to serving you!') }} 😊</p>
      <div class="flex wrap" style="margin-top:26px">
        <a href="{{ route('book') }}" class="btn btn-white btn-lg">{{ __('Book Now') }} <span class="arrow">→</span></a>
        <a href="{{ route('menu') }}" class="btn btn-ghost-light btn-lg">{{ __('View Menu') }}</a>
      </div>
    </div>
    <div class="contact-cards">
      <a class="cc" href="tel:{{ $b['support'] }}"><i>📞</i><div><small>{{ __('Payment & Customer Support') }}</small><b>{{ $b['support'] }}</b></div></a>
      <a class="cc" href="tel:{{ $b['delivery'] }}"><i>🚚</i><div><small>{{ __('Delivery Enquiries') }}</small><b>{{ $b['delivery'] }}</b></div></a>
      <a class="cc" href="#"><i>📍</i><div><small>{{ __('Location') }}</small><b>{{ $b['location'] }}</b></div></a>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
  const plans = @json($plans);
  const menu = @json($menu);
  const slots = @json(collect($slots)->map(fn($s) => ['label' => __($s['label']), 'time' => $s['time'], 'icon' => $s['icon']]));
  const img = name => `{{ asset('assets/img') }}/${name}`;
  const T = { na: @json(__('Mon–Sun only')), perMonth: @json(__('per month')), early: @json(__('Early stop')), day: @json(__('day')) };

  // Plan prices toggle
  initSeg(document.getElementById('sched-seg'), sched => {
    document.querySelectorAll('.plan').forEach(card => {
      const p = plans[card.dataset.plan], amt = card.querySelector('.amt');
      const price = p.prices[sched];
      amt.classList.add('flip');
      setTimeout(() => {
        amt.textContent = price ?? (p.prices['mon-sun']);
        card.querySelector('[data-per]').innerHTML = price
          ? `${T.perMonth} · <b>${T.early}: AED ${p.early_stop}/${T.day}</b>`
          : `${T.perMonth} · <b>${T.na}</b>`;
        amt.classList.remove('flip');
      }, 180);
      const a = card.querySelector('[data-book]');
      a.href = `{{ route('book') }}?plan=${card.dataset.plan}&schedule=${price ? sched : 'mon-sun'}`;
    });
  });

  // Day tabs -> meal cards
  const wrap = document.getElementById('meal-cards');
  const render = day => {
    wrap.innerHTML = Object.entries(menu[day]).map(([slot, m], i) => `
      <article class="meal-card" style="animation-delay:${i * 80}ms">
        <div class="ph"><img src="${img(m[1])}" alt=""><span class="pill gold">${slots[slot].icon} ${slots[slot].label}</span><span class="region">${m[2] === 'KL' ? 'KERALA' : 'TAMIL NADU'}</span></div>
        <div class="bd"><h4>${m[0]}</h4><div class="time">🕒 ${slots[slot].time}</div></div>
      </article>`).join('');
  };
  const tabs = document.querySelectorAll('.day-tab');
  tabs.forEach(t => t.addEventListener('click', () => { tabs.forEach(x => x.classList.remove('on')); t.classList.add('on'); render(t.dataset.day); }));
  render((document.querySelector('.day-tab.on') || tabs[0]).dataset.day);

  // Early stop calculator
  const days = document.getElementById('calc-days');
  const calc = () => {
    const k = document.querySelector('[name=calc-plan]:checked').value, p = plans[k];
    const d = +days.value, paid = p.prices['mon-sun'], used = d * p.early_stop;
    days.style.setProperty('--p', ((d - 1) / 28 * 100) + '%');
    document.getElementById('calc-days-lbl').textContent = d;
    document.getElementById('calc-paid').textContent = 'AED ' + paid;
    document.getElementById('calc-used').textContent = `${d} × ${p.early_stop} = AED ${used}`;
    document.getElementById('calc-refund').textContent = Math.max(0, paid - used);
  };
  days.addEventListener('input', calc);
  document.querySelectorAll('[name=calc-plan]').forEach(r => r.addEventListener('change', calc));
  calc();
})();
</script>
@endpush
