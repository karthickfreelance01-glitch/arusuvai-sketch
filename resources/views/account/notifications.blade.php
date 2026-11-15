@extends('layouts.dash', ['role' => 'customer'])
@section('title', __('Notifications'))
@section('page_title', __('Notifications'))

@section('content')
<div class="dgrid g21">
  <div class="card">
    <div class="card-h">
      <div class="seg" id="nf-seg"><span class="thumb"></span><button class="on" data-value="all">{{ __('All') }}</button><button data-value="delivery">🛵 {{ __('Delivery') }}</button><button data-value="offer">🎁 {{ __('Offers') }}</button><button data-value="account">💳 {{ __('Account') }}</button></div>
      <a href="#" data-toast="{{ __('All caught up') }}|{{ __('Marked all as read') }}|✅">{{ __('Mark all read') }}</a>
    </div>
    @foreach([
      ['delivery','🛵','var(--turmeric-100)',__('Lunch is on the way!'),__('Mohammed is 12 minutes away with your lunch.'),'2m',1],
      ['offer','🎂','var(--chilli-100)',__('Your birthday treat is ready'),__('Free payasam on your birthday + 20% off renewal with code BDAY20.'),'1h',1],
      ['account','⏰','var(--sky-100)',__('Plan renews in 17 days'),__('Renew early and earn 200 bonus points.'),'3h',1],
      ['delivery','✅','var(--leaf-100)',__('Breakfast delivered'),__('Rate your Puttu & Kadala Curry to earn 5 points.'),'6h',0],
      ['offer','🎉','var(--turmeric-100)',__('Double points this Friday'),__('Every meal earns 2x points this Friday only.'),'1d',0],
      ['account','💳','var(--leaf-100)',__('Payment received — AED 390'),__('Thank you! Your 3 Meals Plan is active till 02 Dec.'),'12d',0],
      ['delivery','🔄','var(--cream-2)',__('Meal change confirmed'),__('Tomorrow\'s lunch changed to Veg Pulao & Raita.'),'13d',0],
    ] as $n)
      <div class="notif {{ $n[6] ? 'unread' : '' }}" data-type="{{ $n[0] }}"><span class="i" style="background:{{ $n[2] }}">{{ $n[1] }}</span><div><b>{{ $n[3] }}</b><p>{{ $n[4] }}</p></div><time>{{ $n[5] }}</time></div>
    @endforeach
  </div>
  <div class="card" style="align-self:start">
    <div class="card-h"><h3>{{ __('How we reach you') }}</h3></div>
    @foreach([['💬','WhatsApp',__('Delivery & renewal alerts'),1],['📱','SMS',__('OTP & important updates'),1],['🔔',__('App push'),__('Live delivery tracking'),1],['✉️',__('Email'),__('Receipts & invoices'),1],['🎁',__('Offers & rewards'),__('Birthday, festival offers'),0]] as $p)
      <div class="setrow"><span style="font-size:22px">{{ $p[0] }}</span><div><b>{{ $p[1] }}</b><small>{{ $p[2] }}</small></div><label class="switch"><input type="checkbox" {{ $p[3] ? 'checked' : '' }}><span></span></label></div>
    @endforeach
    <button class="btn btn-ghost btn-block" style="margin-top:16px" onclick="toast(@js(__('Test notification')), @js(__('This is how alerts will look.')), '🔔')">{{ __('Send me a test alert') }}</button>
  </div>
</div>
@endsection
@push('scripts')
<script>initSeg(document.getElementById('nf-seg'), v => document.querySelectorAll('.notif[data-type]').forEach(n => n.style.display = v === 'all' || n.dataset.type === v ? 'flex' : 'none'));</script>
@endpush
