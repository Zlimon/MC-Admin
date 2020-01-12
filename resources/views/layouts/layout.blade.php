<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config(str_replace('-', ' ', 'app.name'), 'HabskiCMS') }} | @yield('title')</title>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.css">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" >

	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<section class="section">
	<div class="container has-background-grey-light">
		<div class="columns">
			<div class="column is-four-fifths">
				<h1 class="title">Server manager</h1>
				<p class="subtitle">Monitor and control your server from here</p>
			</div>

			<div class="column">
				@if (Server::pingServer())
					<span class="tag is-success">Online</span>
				@else
					<span class="tag is-danger">Offline</span>
				@endif

				<img src="https://www.freeiconspng.com/uploads/minecraft-server-icon-4.png" width="64px" height="64px">
			</div>
		</div>

		<hr>

		@if ($errors->any())
			<div class="alert alert-danger col-md-4" style="margin: auto; margin-bottom: 1rem;">
				@foreach ($errors->all() as $errorMessage)
					<strong>Error!</strong> {{ $errorMessage }}<br>
				@endforeach
			</div>
		@endif

		@if (Session::has('message'))
			<div class="alert alert-success col-md-4" style="margin: auto; margin-bottom: 1rem;">
				<strong>Success!</strong> {{ Session::get('message') }}<br>
			</div>
		@endif

		<div class="columns">
			<div class="column is-one-fifth">
				<aside class="menu has-background-primary">
					<p class="menu-label">General</p>
					<ul class="menu-list">
						<li><a>Overview</a></li>
						<li><a>Console</a></li>
					</ul>
					<p class="menu-label">Administration</p>
					<ul class="menu-list">
						<li><a>Plugins</a></li>
						<li><a>Backups</a></li>
						<!-- <li>
							<a class="is-active">Manage Your Team</a>
							<ul>
								<li><a>Members</a></li>
								<li><a>Plugins</a></li>
								<li><a>Add a member</a></li>
							</ul>
						</li> -->
						<li><a>Scheduled Tasks</a></li>
					</ul>
					<p class="menu-label">???</p>
					<ul class="menu-list">
						<li><a>Permissions</a></li>
						<li><a>Players</a></li>
						<li><a>Worlds</a></li>
					</ul>
				</aside>
			</div>

			<div class="column">
				@yield('content')
			</div>
		</div>
</section>
</body>
</html