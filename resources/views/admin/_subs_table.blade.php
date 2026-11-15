@php
  $rows = [
    ['Karthik Ramesh','+971 56 619 9944','Room 214, Al Hamra Residence','3 Meals','Mon–Sat',390,'Active','Stripe','03 Nov','#c73a1d'],
    ['Anoop Menon','+971 50 221 4410','Room 118, DIP 2 Block C','2 Meals','Mon–Sun',320,'Active','Stripe','02 Nov','#17603a'],
    ['Rahul Joshi','+971 55 908 1123','Site Office, Green Community','1 Meal','Mon–Sun',220,'Active','Apple Pay','01 Nov','#ee7a1b'],
    ['Senthil Kumar','+971 52 334 7781','Room 9, Camp Zone A','3 Meals','Mon–Sun',450,'Renew soon','Stripe','18 Oct','#2b78c4'],
    ['Fathima Nazar','+971 56 775 2209','Flat 302, DIP 2 Residence','2 Meals','Mon–Fri',280,'Cash pending','Cash','14 Nov','#a82e15'],
    ['Joseph Varghese','+971 58 120 9934','Room 41, Jebel Ali Ind.','3 Meals','Mon–Fri',350,'Paused','Stripe','27 Oct','#134d2c'],
    ['Priya Lakshmi','+971 54 671 3390','Flat 11, Green Community','1 Meal','Mon–Sun',220,'Active','Google Pay','10 Nov','#d9650b'],
    ['Arun Prakash','+971 50 448 6612','Room 77, Camp Zone B','2 Meals','Mon–Sat',300,'Early stop','Stripe','21 Oct','#5f584b'],
    ['Deepak Nair','+971 52 903 4471','Room 5, DIP 2 Block A','3 Meals','Mon–Sat',390,'Active','Stripe','12 Nov','#2e8b4e'],
    ['Imran Sheikh','+971 55 216 7740','Room 230, Al Hamra Residence','2 Meals','Mon–Sun',320,'Active','Stripe','09 Nov','#17518a'],
  ];
  $pill = ['Active'=>'pill','Renew soon'=>'pill gold','Cash pending'=>'pill sky','Paused'=>'pill grey','Early stop'=>'pill red'];
  $rows = array_slice($rows, 0, $limit ?? 99);
@endphp
<div class="table-wrap">
  <table class="t" id="subs">
    <thead><tr><th>{{ __('Customer') }}</th><th>{{ __('Address') }}</th><th>{{ __('Plan') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Payment') }}</th><th>{{ __('Started') }}</th><th>{{ __('Status') }}</th><th></th></tr></thead>
    <tbody>
    @foreach($rows as $r)
      <tr data-status="{{ $r[6] }}">
        <td><div class="who"><span class="av" style="background:{{ $r[9] }}">{{ collect(explode(' ', $r[0]))->map(fn($w) => $w[0])->join('') }}</span><div><b>{{ $r[0] }}</b><small>{{ $r[1] }}</small></div></div></td>
        <td class="muted">{{ $r[2] }}</td>
        <td><b>{{ $r[3] }}</b><br><small class="muted">{{ $r[4] }}</small></td>
        <td><b>AED {{ $r[5] }}</b></td>
        <td>{{ $r[7] }}</td>
        <td>{{ $r[8] }}</td>
        <td><span class="{{ $pill[$r[6]] }}"><span class="dot"></span> {{ __($r[6]) }}</span></td>
        <td><a href="https://wa.me/{{ preg_replace('/\D/', '', $r[1]) }}" target="_blank" rel="noopener" title="WhatsApp">💬</a> &nbsp;<a href="#" data-toast="{{ __('Opening profile') }}|{{ $r[0] }}|👤">⋯</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
