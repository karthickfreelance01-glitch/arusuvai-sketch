@php $langs = config('arusuvai.languages'); $cur = app()->getLocale(); @endphp
<div class="lang" data-dropdown>
  <button type="button" class="lang-btn" data-dropdown-btn aria-label="Language">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg>
    <span>{{ $langs[$cur]['native'] }}</span>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 9 6 6 6-6"/></svg>
  </button>
  <div class="lang-menu" data-dropdown-menu>
    @foreach($langs as $code => $l)
      <a href="{{ route('lang', $code) }}" class="{{ $cur === $code ? 'on' : '' }}"><span>{{ $l['native'] }}</span><span>{{ $l['label'] }}</span></a>
    @endforeach
  </div>
</div>
