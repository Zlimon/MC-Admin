<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Helpers\Server;
use App\Helpers\RCON;
use App\Helpers\Helper;

use App\StatsPlayer;

class PagesController extends Controller
{
	public function index() {
		$serverInfo = Server::getServerInfo();

		$playerInfo = Server::getPlayers();

		$players = StatsPlayer::with('playtime')->with('lastQuit')->get();

		return view('index', compact('serverInfo', 'playerInfo', 'players'));
	}

	public function stopServer() {
		if (Helper::isServerOnline()) {
			$response = RCON::executeRcon('stop');

			if ($response) {
				DB::table('server_settings')
					->where('key', 'online')
					->update(['value' => 'false']);

				return redirect(route('index'))->with('message', $response);
			} else {
				return redirect(route('index'))->withErrors(['Something went wrong!']);
			}
		} else {
			return redirect(route('index'))->withErrors(['The server already is disabled!']);
		}
	}

	public function executeRcon() {
		$commandComponents = request()->validate([
			'command' => ['required', 'string', 'max:200'],
			'username' => ['max:200'],
		]);

		$command = $commandComponents["command"].' '.$commandComponents["username"];

		$response = RCON::executeRcon($command);

		//dd($response);
// redirect(route('index'))->withErrors([$e->getMessage()]);
		return redirect(route('index'))->with('message', $response);
	}

	public function autocomplete(Request $request) {
		if ($request->get('query')) {
			$query = $request->get('query');
			$data = DB::table('stats_players')
				->select('username')
				->where('username', 'LIKE', "%{$query}%")
				->get();

			foreach ($data as $key => $value) {
				echo '<a href="#" class="dropdown-item">'.$data[$key]->username.'</a>';
			}
		}
	}

	public function test() {
		return view('test');
	}
}
