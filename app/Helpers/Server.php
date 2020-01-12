<?php

namespace App\Helpers;

// use xPaw\MinecraftPing;
// use xPaw\MinecraftPingException;
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

use App\Helpers\Helper;

class Server
{
	public static function pingServer($info = false) {
		if (Helper::isServerOnline()) {
			$server = new MinecraftQuery();

			try {
				$server->Connect(Helper::setting('host'), Helper::setting('port'));

				if ($info === 'serverInfo') {
					return $server->GetInfo();
				} elseif ($info === 'playerInfo') {
					return $server->GetPlayers();
				} else {
					return true;
				}
			} catch (MinecraftQueryException $e) {
				if ($info === false) {
					return false;
				} else {
					return $e->getMessage();
				}
			}
		} else {
			return false;
		}
	}

	public static function getServerInfo() {
		return self::pingServer('serverInfo');
	}

	public static function getPlayers() {
		return self::pingServer('playerInfo');
	}
}
