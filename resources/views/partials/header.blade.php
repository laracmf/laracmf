<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ config('cms.description') }}">
<meta name="author" content="{{ config('cms.author') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/bootstrap.' . config('theme.name', 'default') . '.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/all.css') }}">

<script src="{{ asset('assets/scripts/all.js') }}"></script>

<!--[if lt IE 9]>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">
