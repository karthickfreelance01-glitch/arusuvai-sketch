@php
  $c = config('arusuvai.demo_customer');
  $start = \Carbon\Carbon::parse($c['start'])->startOfDay();
  $offDay = $c['schedule'] === 'mon-sun' ? [] : ($c['schedule'] === 'mon-sat' ? [0] : [0, 6]);
  $todayD = now()->startOfDay();
  $first = $start->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
@endphp
<div class="cal">
  @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)<div class="h">{{ __($d) }}</div>@endforeach
  @for($i = 0; $i < 35; $i++)
    @php
      $d = $first->copy()->addDays($i);
      $in = $d->gte($start) && $d->lt($start->copy()->addDays(30));
      $cls = !$in ? 'x' : (in_array($d->dayOfWeek, $offDay) ? 'off' : ($d->eq($todayD) ? 'today' : ($d->lt($todayD) ? 'ok' : 'up')));
    @endphp
    <div class="d {{ $cls }}" title="{{ $d->format('D d M') }}">{{ $d->format('j') }}</div>
  @endfor
</div>
