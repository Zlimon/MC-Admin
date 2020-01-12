@extends('layouts.layout')

@section('title')
	Home
@endsection

@section('content')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<div class="columns is-vcentered">
		<div class="column is-one-quarter">
			<div class="buttons">
				@if (Helper::isServerOnline())
					<form method="POST" action="{{ route('stop-server') }}">
						@method('PATCH')
						@csrf
						
						<button class="button is-danger">
							<span class="icon">
								<i class="fas fa-power-off"></i>
							</span>
							<span>Shutdown</span>
						</button>
					</form>

					<button class="button is-warning">
						<span class="icon">
							<i class="fas fa-redo"></i>
						</span>
						<span>Reboot</span>
					</button>
				@else
					<button type="submit" class="button is-success">
						<span class="icon">
							<i class="fas fa-play"></i>
						</span>
						<span>Start</span>
					</button>
				@endif
			</div>
		</div>

		@if (Helper::isServerOnline())
			<div class="column">
				<p class="has-text-centered">{{ $serverInfo['Players'] }} / {{ $serverInfo['MaxPlayers'] }} players  {{ number_format((float)(($serverInfo['Players'] * 100) / $serverInfo['MaxPlayers']), 2, '.', '') }}%</p>
				<progress class="progress is-medium is-primary" value="{{ $serverInfo['Players'] }}" max="{{ $serverInfo['MaxPlayers'] }}">{{ number_format((float)(($serverInfo['Players'] * 100) / $serverInfo['MaxPlayers']), 2, '.', '') }}%</progress>
			</div>
		@endif
	</div>

	@if (Helper::isServerOnline())
		<div class="columns">
			<div class="column">
				<p><strong>Running:</strong> {{ $serverInfo["Software"] }}</p>
				<p><strong>Players:</strong> {{ $serverInfo["Players"] }} / {{ $serverInfo["MaxPlayers"] }}</p>
				<p><strong>Server:</strong> {{ Helper::setting('host') }}</p>
			</div>

			<div class="column">
				<p><strong>MOTD:</strong> {{ $serverInfo["HostName"] }}</p>
				<p><strong>Version:</strong> {{ ucfirst(strtolower($serverInfo["GameName"])) }} - {{ $serverInfo["Version"] }}</p>
				<p><strong>Plugins:</strong> {{ sizeOf($serverInfo["Plugins"]) }}</p>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<table class="table">
					<thead>
						<th>Player</th>
						<th>Status</th>
						<th>Playtime</th>
						<th>Last seen</th>
					</thead>
					<tbody>
						@foreach ($players as $player)
							<tr>
								<th><img src="https://minotar.net/avatar/{{ $player->username }}" width="15%"> {{ $player->username }}</th>
								<td>
									@if ($playerInfo)
										@if (in_array($player->username, $playerInfo))
											<span class="tag is-success">Online</span>
										@else
											<span class="tag is-danger">Offline</span>
										@endif
									@else
										<span class="tag is-danger">Offline</span>
									@endif
								</td>
								<td>{{ $player->playtime->amount }}</td>
								<td>{{ $player->lastQuit->timestamp }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<form method="POST" action="{{ route('execute-rcon') }}">
					@csrf

					<div class="field is-grouped has-addons">
						<p class="control">
							<span class="button is-static">/</span>
						</p>
						<div class="control is-expanded">
							<input id="command" type="text" class="input @error('command') is-danger @enderror" name="command" placeholder="Enter a command" required>

							@error('command')
								<p class="help is-danger">{{ $message }}</p>
							@enderror
						</div>

						<div class="control">
							<input id="username" type="text" class="input @error('username') is-danger @enderror" name="username"  placeholder="Enter a player username">

							@error('username')
								<p class="help is-danger">{{ $message }}</p>
							@enderror

							<div class="dropdown is-active">
								<div class="dropdown-menu" id="dropdown-menu" role="menu">
									<div id="playerList" class="dropdown-content is-hidden">
									</div>
								</div>
							</div>
						</div>
						<p class="control">
							<button type="submit" class="button is-success">Submit</button>
						</p>
					</div>
				</form>
			</div>
		</div>

		<script>
			$(document).ready(function() {
				$('#username').keyup(function() {
					var query = $(this).val();
					if (query != '') {
						var _token = $('input[name="_token"]').val();
						$.ajax({
							url:"{{ route('autocomplete.fetch') }}",
							method:"POST",
							data:{query:query, _token:_token},
							success:function(data) {
								$('#playerList').removeClass('is-hidden').fadeIn();
								$('#playerList').html(data);
							}
						});
					}
				});

				$(document).on('click', 'a', function() {
					$('#username').val($(this).text());
					$('#playerList').fadeOut();
				});
			});
		</script>
	@else
		<h1 class="title">server disabled</h1>
	@endif
@endsection