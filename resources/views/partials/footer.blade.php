@php $b = config('arusuvai.brand'); @endphp
<footer class="footer">
  <div class="container">
    <div class="grid">
      <div>
        <a href="{{ route('home') }}" class="brand"><img src="{{ asset('assets/img/logo.png') }}" alt=""><span>Arusuvai Mess<small>{{ $b['tagline'] }}</small></span></a>
        <p>{{ __('Affordable, fresh & homely Tamil Nadu and Kerala meals delivered daily in Dubai Investment Park 2.') }}</p>
        <div class="pay-logos"><span>VISA</span><span>Mastercard</span><span>Apple Pay</span><span>G Pay</span><span>stripe</span></div>
      </div>
      <div>
        <h4>{{ __('Explore') }}</h4>
        <a href="{{ route('home') }}#plans">{{ __('Meal Plans') }}</a>
        <a href="{{ route('menu') }}">{{ __('Weekly Menu') }}</a>
        <a href="{{ route('book') }}">{{ __('Book Now') }}</a>
        <a href="{{ route('meal-change') }}">{{ __('Meal Change') }}</a>
      </div>
      <div>
        <h4>{{ __('Account') }}</h4>
        <a href="{{ route('login') }}">{{ __('Login') }}</a>
        <a href="{{ route('register') }}">{{ __('Register') }}</a>
        <a href="{{ route('account.home') }}">{{ __('My Dashboard') }}</a>
        <a href="{{ route('account.rewards') }}">{{ __('Rewards') }}</a>
        <a href="{{ route('admin.home') }}">{{ __('Admin Panel') }}</a>
      </div>
      <div>
        <h4>{{ __('Contact') }}</h4>
        <a href="tel:{{ $b['support'] }}">📞 {{ __('Payment & Support') }}: {{ $b['support'] }}</a>
        <a href="tel:{{ $b['delivery'] }}">🚚 {{ __('Delivery') }}: {{ $b['delivery'] }}</a>
        <a href="https://wa.me/{{ $b['whatsapp'] }}" target="_blank" rel="noopener">💬 WhatsApp</a>
        <a href="#">📍 {{ $b['location'] }}, Dubai</a>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© {{ date('Y') }} Arusuvai Mess. {{ __('All rights reserved.') }}</span>
      <span>{{ __('Made with love, spice & banana leaves') }} 🍃</span>
    </div>
  </div>
</footer>
