<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#0e3b22">
<title>@yield('title', __('30 Days Meal Plan')) · Arusuvai Mess</title>
<meta name="description" content="{{ __('Affordable, fresh & homely Tamil Nadu and Kerala meals delivered daily in Dubai Investment Park 2.') }}">
<link rel="icon" href="{{ asset('assets/img/logo.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@php
  $fontExtra = [
    'ta' => '&family=Noto+Sans+Tamil:wght@400;600;700;800&family=Noto+Serif+Tamil:wght@600;700;800',
    'ml' => '&family=Noto+Sans+Malayalam:wght@400;600;700;800&family=Noto+Serif+Malayalam:wght@600;700;800',
    'hi' => '&family=Noto+Sans+Devanagari:wght@400;600;700;800&family=Noto+Serif+Devanagari:wght@600;700;800',
  ][app()->getLocale()] ?? '';
@endphp
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..800;1,9..144,500..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800{!! $fontExtra !!}&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}?v=1">
@if(config('arusuvai.static'))
<script>window.ARU_STATIC = @json(['base' => config('arusuvai.static_base'), 'links' => array_filter(config('arusuvai.payment_links'))]);</script>
@endif
