@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Admin Dashboard'))
@section('page_title', __('Dashboard'))
@php
  $rev = ['Dec'=>286,'Jan'=>301,'Feb'=>318,'Mar'=>309,'Apr'=>334,'May'=>352,'Jun'=>347,'Jul'=>361,'Aug'=>379,'Sep'=>388,'Oct'=>401,'Nov'=>413];
  $max = max($rev);
  $menu = config('arusuvai.menu')[now()->format('l')];
@endphp

@section('content')
<div class="dgrid g4">
  <div class="card kpi dark"><span class="ico">👥</span><div class="lbl">{{ __('Active subscribers') }}</div><div class="val" data-count="1248">0</div><div class="delta">↑ 6.4% {{ __('vs last month') }}</div></div>
  <div class="card kpi"><span class="ico">💰</span><div class="lbl">{{ __('Revenue this month') }}</div><div class="val">AED <span data-count="413">0</span>k</div><div class="delta">↑ 3.0% {{ __('vs last month') }}</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--turmeric-100)">🍛</span><div class="lbl">{{ __('Meals today') }}</div><div class="val" data-count="2986">0</div><div class="delta">B 1,012 · L 1,104 · D 870</div></div>
  <div class="card kpi"><span class="ico" style="background:var(--chilli-100)">⏰</span><div class="lbl">{{ __('Renewals due (7 days)') }}</div><div class="val" data-count="94">0</div><div class="delta down">AED 31,420 {{ __('at stake') }}</div></div>
</div>

<div class="dgrid g21">
  <div class="card">
    <div class="card-h"><div><h3>{{ __('Monthly revenue') }}</h3><small class="muted" style="font-weight:600">AED '000 · {{ __('last 12 months') }}</small></div><div class="seg" id="rv-seg"><span class="thumb"></span><button class="on" data-value="rev">{{ __('Revenue') }}</button><button data-value="table">{{ __('Table') }}</button></div></div>
    <div class="bars" id="rv-bars" role="img" aria-label="{{ __('Monthly revenue') }}">
      @foreach($rev as $m => $v)
        <div class="b {{ $loop->last ? 'hi' : '' }}" title="{{ __($m) }}: AED {{ $v }}k">
          @if($loop->last)<b style="font-size:13px">{{ $v }}k</b>@endif
          <span style="height:{{ round($v / $max * 100) }}%"></span><small>{{ __($m) }}</small>
        </div>
      @endforeach
    </div>
    <div class="table-wrap" id="rv-table" style="display:none"><table class="t"><thead><tr>@foreach($rev as $m => $v)<th>{{ __($m) }}</th>@endforeach</tr></thead><tbody><tr>@foreach($rev as $v)<td>{{ $v }}k</td>@endforeach</tr></tbody></table></div>
  </div>
  <div class="card">
    <div class="card-h"><h3>{{ __('Plan mix') }}</h3><small class="muted" style="font-weight:700">1,248 {{ __('subscribers') }}</small></div>
    <div style="display:flex;height:18px;border-radius:6px;overflow:hidden;gap:2px;margin-bottom:22px">
      <span style="width:46%;background:#2e8b4e"></span><span style="width:35%;background:#d99a06"></span><span style="width:19%;background:#2b78c4"></span>
    </div>
    @foreach([['#2e8b4e','3 Meals Plan',574,46],['#d99a06','2 Meals Plan',437,35],['#2b78c4','1 Meal Plan',237,19]] as $p)
      <div class="setrow"><i style="width:12px;height:12px;border-radius:4px;background:{{ $p[0] }}"></i><div><b>{{ __($p[1]) }}</b><small>{{ $p[2] }} {{ __('subscribers') }}</small></div><b>{{ $p[3] }}%</b></div>
    @endforeach
    <div class="setrow"><span>📅</span><div><b>{{ __('Most popular days') }}</b><small>{{ __('Monday – Saturday') }}</small></div><b>52%</b></div>
  </div>
</div>

<div class="dgrid g3">
  <div class="card">
    <div class="card-h"><h3>🍳 {{ __('Kitchen today') }}</h3><span class="pill gold"><span class="dot"></span> {{ __('Live') }}</span></div>
    @foreach([['☀️',__('Breakfast'),$menu['breakfast'][0],1012,100,'pill',__('Dispatched')],['🍛',__('Lunch'),$menu['lunch'][0],1104,72,'pill gold',__('Packing')],['🌙',__('Dinner'),$menu['dinner'][0],870,15,'pill grey',__('Prep')]] as $k)
      <div style="padding:12px 0;border-bottom:1px solid #f2ebdc">
        <div class="flex between"><b>{{ $k[0] }} {{ $k[1] }} · {{ number_format($k[3]) }}</b><span class="{{ $k[5] }}">{{ $k[6] }}</span></div>
        <small class="muted">{{ $k[2] }}</small>
        <div class="progress" style="margin-top:8px"><span style="width:{{ $k[4] }}%"></span></div>
      </div>
    @endforeach
  </div>
  <div class="card">
    <div class="card-h"><h3>🛵 {{ __('Riders on route') }}</h3><a href="{{ route('admin.deliveries') }}">{{ __('Live map') }} →</a></div>
    @foreach([['MA','Mohammed Ashraf','Camp Zone A',38,'#2b78c4',82],['SR','Suresh Raj','DIP 2 Block C',42,'#c73a1d',55],['VK','Vinod Kumar','Green Community',27,'#17603a',30],['AJ','Ajith Joseph','Jebel Ali Ind.',31,'#ee7a1b',12]] as $r)
      <div class="setrow"><div class="who" style="flex:1"><span class="av" style="background:{{ $r[4] }}">{{ $r[0] }}</span><div><b>{{ $r[1] }}</b><small>{{ $r[2] }} · {{ $r[3] }} {{ __('drops') }}</small><div class="progress" style="height:6px;margin-top:6px;width:140px"><span style="width:{{ $r[5] }}%"></span></div></div></div><b>{{ $r[5] }}%</b></div>
    @endforeach
  </div>
  <div class="card">
    <div class="card-h"><h3>⚡ {{ __('Needs attention') }}</h3></div>
    @foreach([['🔄','var(--turmeric-100)',__('17 meal change requests'),__('For tomorrow'),route('admin.subscribers')],['⏰','var(--chilli-100)',__('94 renewals due'),__('Send WhatsApp reminder'),route('admin.notifications')],['💳','var(--sky-100)',__('9 cash payments pending'),__('Collect & mark paid'),route('admin.payments')],['🎂','var(--leaf-100)',__('23 birthdays this week'),__('Birthday offer auto-sent'),route('admin.marketing')],['⏹️','var(--cream-2)',__('3 early stop requests'),__('Refunds to approve'),route('admin.payments')]] as $a)
      <a href="{{ $a[4] }}" class="notif" style="padding:12px 0"><span class="i" style="background:{{ $a[1] }}">{{ $a[0] }}</span><div><b>{{ $a[2] }}</b><p>{{ $a[3] }}</p></div><time>→</time></a>
    @endforeach
  </div>
</div>

<div class="card">
  <div class="card-h"><h3>{{ __('Latest registrations') }}</h3><a href="{{ route('admin.subscribers') }}">{{ __('View all') }} →</a></div>
  @include('admin._subs_table', ['limit' => 6])
</div>
@endsection

@push('scripts')
<script>initSeg(document.getElementById('rv-seg'), v => { document.getElementById('rv-bars').style.display = v === 'rev' ? 'flex' : 'none'; document.getElementById('rv-table').style.display = v === 'table' ? 'block' : 'none'; });</script>
@endpush
