@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Menu & Meals'))
@section('page_title', __('Menu & Meals'))
@section('page_sub', __('Weekly rotating menu'))
@php $menu = config('arusuvai.menu'); $slots = config('arusuvai.meal_slots'); @endphp
@section('content')
<div class="card">
  <div class="card-h wrap">
    <div class="seg" id="slot-seg"><span class="thumb"></span><button class="on" data-value="all">{{ __('All') }}</button>@foreach($slots as $k => $s)<button data-value="{{ $k }}">{{ $s['icon'] }} {{ __($s['label']) }}</button>@endforeach</div>
    <div class="flex"><button class="btn btn-ghost btn-sm" data-toast="{{ __('Menu published') }}|{{ __('Customers notified on WhatsApp') }}|📣">📣 {{ __('Publish to customers') }}</button><button class="btn btn-sm" data-toast="{{ __('New dish') }}|{{ __('Dish editor opened') }}|🍛">＋ {{ __('Add dish') }}</button></div>
  </div>
  <div class="table-wrap">
    <table class="t">
      <thead><tr><th>{{ __('Day') }}</th>@foreach($slots as $k => $s)<th data-col="{{ $k }}">{{ $s['icon'] }} {{ __($s['label']) }}</th>@endforeach</tr></thead>
      <tbody>
        @foreach($menu as $day => $meals)
          <tr><td><b style="font-family:var(--f-display);font-size:18px">{{ __($day) }}</b></td>
            @foreach($meals as $slot => $m)
              <td data-col="{{ $slot }}" style="white-space:normal;min-width:220px"><div class="who"><img src="{{ asset('assets/img/'.$m[1]) }}" alt="" style="width:52px;height:52px;border-radius:12px;object-fit:cover"><div><b style="font-size:14px">{{ $m[0] }}</b><small><span class="pill {{ $m[2]==='KL' ? 'gold' : '' }}" style="padding:2px 8px;font-size:11px">{{ $m[2]==='KL' ? __('Kerala') : __('Tamil Nadu') }}</span> <a href="#" data-toast="{{ __('Editing') }}|{{ $m[0] }}|✏️">✏️</a></small></div></div></td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="dgrid g3">
  <div class="card"><div class="card-h"><h3>⭐ {{ __('Top rated dishes') }}</h3></div>
    @foreach([['Sunday Special Sadya',4.9],['Ghee Roast Dosa',4.8],['Appam & Vegetable Stew',4.8],['Chicken / Veg Biryani',4.7]] as $d)<div class="setrow"><div><b>{{ $d[0] }}</b></div><span class="pill gold">★ {{ $d[1] }}</span></div>@endforeach
  </div>
  <div class="card"><div class="card-h"><h3>🔄 {{ __('Most swapped') }}</h3></div>
    @foreach([['Upma & Coconut Chutney',41],['Kothu Parotta',28],['Idiyappam & Curry',19]] as $d)<div class="setrow"><div><b>{{ $d[0] }}</b><small>{{ $d[1] }} {{ __('requests this month') }}</small></div></div>@endforeach
  </div>
  <div class="card"><div class="card-h"><h3>🧾 {{ __('Tomorrow\'s prep') }}</h3></div>
    @foreach([['🍚','Rice','148 kg'],['🫘','Toor dal','36 kg'],['🥥','Coconut','420 pcs'],['🥬','Vegetables','210 kg']] as $d)<div class="setrow"><span style="font-size:20px">{{ $d[0] }}</span><div><b>{{ $d[1] }}</b></div><b>{{ $d[2] }}</b></div>@endforeach
  </div>
</div>
@endsection
@push('scripts')
<script>initSeg(document.getElementById('slot-seg'), v => document.querySelectorAll('[data-col]').forEach(c => c.style.display = v === 'all' || c.dataset.col === v ? '' : 'none'));</script>
@endpush
