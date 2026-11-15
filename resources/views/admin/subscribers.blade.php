@extends('layouts.dash', ['role' => 'admin'])
@section('title', __('Subscribers'))
@section('page_title', __('Subscribers'))
@section('page_sub', '1,248 ' . __('active') . ' · 94 ' . __('renewals due'))
@section('content')
<div class="dgrid g4">
  @foreach([['✅',__('Active'),'1,148','pill'],['⏰',__('Renew soon'),'94','pill gold'],['⏸️',__('Paused'),'31','pill grey'],['💵',__('Cash pending'),'9','pill sky']] as $k)
    <div class="card kpi"><span class="ico">{{ $k[0] }}</span><div class="lbl">{{ $k[1] }}</div><div class="val">{{ $k[2] }}</div></div>
  @endforeach
</div>
<div class="card">
  <div class="card-h wrap">
    <div class="seg" id="st-seg"><span class="thumb"></span>
      @foreach(['all'=>__('All'),'Active'=>__('Active'),'Renew soon'=>__('Renew soon'),'Paused'=>__('Paused'),'Cash pending'=>__('Cash pending'),'Early stop'=>__('Early stop')] as $v => $l)<button class="{{ $v==='all' ? 'on' : '' }}" data-value="{{ $v }}">{{ $l }}</button>@endforeach
    </div>
    <div class="flex"><button class="btn btn-ghost btn-sm" data-toast="{{ __('Export started') }}|subscribers.xlsx|📥">📥 {{ __('Export') }}</button><a href="{{ route('book') }}" class="btn btn-sm">＋ {{ __('Add subscriber') }}</a></div>
  </div>
  @include('admin._subs_table')
</div>
@endsection
@push('scripts')
<script>initSeg(document.getElementById('st-seg'), v => document.querySelectorAll('#subs tbody tr').forEach(tr => tr.style.display = v === 'all' || tr.dataset.status === v ? '' : 'none'));</script>
@endpush
