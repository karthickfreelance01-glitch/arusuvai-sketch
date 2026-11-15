@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Notifications'))
@section('page_title', __('Notifications'))
@section('page_sub', __('WhatsApp · SMS · Push · Email'))
@php $b = config('arusuvai.brand'); @endphp
@section('content')
<div class="dgrid g21">
  <div class="card">
    <div class="card-h"><h3>📣 {{ __('Send a broadcast') }}</h3></div>
    <div class="label" style="margin-bottom:10px">{{ __('Channels') }}</div>
    <div class="opts c4" style="margin-bottom:18px">
      @foreach([['💬','WhatsApp',1],['📱','SMS',0],['🔔','Push',1],['✉️','Email',0]] as $ch)
        <label class="opt"><input type="checkbox" {{ $ch[2] ? 'checked' : '' }}><div class="box" style="text-align:center;padding:14px"><span class="em">{{ $ch[0] }}</span><span class="t" style="font-size:14px">{{ $ch[1] }}</span></div><span class="tick">✓</span></label>
      @endforeach
    </div>
    <div class="row-2">
      <div class="field"><label>{{ __('Template') }}</label>
        <select class="select" id="tpl">
          <option value="welcome">{{ __('Welcome / enquiry reply') }}</option>
          <option value="renew">{{ __('Renewal reminder') }}</option>
          <option value="delivery">{{ __('Delivery delayed') }}</option>
          <option value="bday">{{ __('Birthday offer') }}</option>
        </select>
      </div>
      <div class="field"><label>{{ __('Language') }}</label>
        <select class="select">@foreach(config('arusuvai.languages') as $l)<option>{{ $l['native'] }}</option>@endforeach<option>{{ __('Customer\'s language') }}</option></select>
      </div>
    </div>
    <div class="field"><label>{{ __('Audience') }}</label><select class="select"><option>{{ __('New enquiries') }}</option><option>{{ __('Renewals due in 7 days') }} (94)</option><option>{{ __('All active subscribers') }} (1,248)</option><option>{{ __('Lunch route · Camp Zone A') }} (38)</option></select></div>
    <div class="field"><label>{{ __('Message') }}</label><textarea class="textarea" id="msg" rows="12"></textarea></div>
    <div class="flex wrap"><button class="btn btn-spice" data-toast="{{ __('Broadcast queued') }}|{{ __('Sending to selected customers') }}|📣">📣 {{ __('Send now') }}</button><button class="btn btn-ghost" data-toast="{{ __('Scheduled') }}|{{ __('Tomorrow 9:00 AM') }}|🗓️">🗓️ {{ __('Schedule') }}</button></div>
  </div>
  <div class="dgrid" style="align-content:start">
    <div class="phone">
      <div class="scr">
        <div class="wa-h"><img src="{{ asset('assets/img/logo.png') }}" alt="" style="width:34px;height:34px;border-radius:50%;background:#fff"><div><b style="font-size:14px">Arusuvai Mess</b><br><small style="opacity:.8">{{ __('Business account') }}</small></div></div>
        <div class="bubble" id="preview"></div>
        <div class="bubble" style="align-self:flex-end;background:#dcf8c6;border-radius:12px 12px 2px 12px">{{ __('3 meals, Mon–Sat from Monday please') }} 🙏</div>
      </div>
    </div>
    <div class="card">
      <div class="card-h"><h3>⚙️ {{ __('Automatic alerts') }}</h3></div>
      @foreach([[__('Out for delivery'),__('Push + WhatsApp'),1],[__('Renewal reminder (5 days)'),'WhatsApp',1],[__('Payment receipt'),__('Email + WhatsApp'),1],[__('Birthday offer'),'WhatsApp',1],[__('Menu of the week'),__('Every Sunday'),0]] as $a)
        <div class="setrow"><div><b>{{ $a[0] }}</b><small>{{ $a[1] }}</small></div><label class="switch"><input type="checkbox" {{ $a[2] ? 'checked' : '' }}><span></span></label></div>
      @endforeach
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
(() => {
  const tpl = {
    welcome: `Hi 👋\n\nThank you for contacting Arusuvai Mess 🍽️\n\nWe are happy to serve you with our 30 Days Meal Plan – Affordable, Fresh & Homely Food.\n\n📌 Our Plans:\n🥘 1 Time Meal – Starting from 220 AED\n🥘 2 Times Meals – Starting from 280 AED\n🥘 3 Times Meals – Starting from 350 AED\n\n📝 Service Registration:\n{{ url('/book-now') }}\n\n🔄 Menu Change:\n{{ url('/meal-change') }}\n\n📖 View Menu:\n{{ url('/menu') }}\n\n📍 Location: {{ $b['location'] }}\n📞 Payment & Customer Support: {{ $b['support'] }}\n🚚 Delivery Enquiries: {{ $b['delivery'] }}\n\n💳 Note: One month payment should be made in advance at the time of registration.\n\nPlease let us know your preferred meal plan and starting date. We look forward to serving you 😊`,
    renew: `Hi {name} 👋\n\nYour Arusuvai 30 Days Meal Plan ends on {date}.\n\nRenew now in one tap and earn 200 bonus points 🏆\n{{ url('/book-now') }}\n\nThank you for eating with us 🍃`,
    delivery: `Hi {name},\n\nSorry! Your lunch is running about 10 minutes late due to traffic on DIP 2 road 🛵\n\nTrack live: {{ url('/account/track') }}\n\nFor help call {{ $b['delivery'] }}`,
    bday: `Happy Birthday {name}! 🎂🎉\n\nA free payasam is coming with your lunch today, and you get 20% off your next month with code BDAY20.\n\n{{ url('/book-now') }}`,
  };
  const msg = document.getElementById('msg'), pv = document.getElementById('preview'), sel = document.getElementById('tpl');
  const sync = () => pv.textContent = msg.value.replaceAll('{name}', 'Karthik').replaceAll('{date}', '02 Dec');
  sel.addEventListener('change', () => { msg.value = tpl[sel.value]; sync(); });
  msg.addEventListener('input', sync);
  msg.value = tpl.welcome; sync();
})();
</script>
@endpush
