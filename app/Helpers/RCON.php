<?php

namespace App\Helpers;

use xPaw\SourceQuery\SourceQuery;

class RCON
{
	public static function executeRcon($command) {
		if (Helper::isServerOnline()) {
			define('SQ_SERVER_ADDR', Helper::setting('rcon_host'));
			define('SQ_SERVER_PORT', Helper::setting('rcon_port'));
			define('SQ_TIMEOUT',     10);
			define('SQ_ENGINE',      SourceQuery::SOURCE);

			$query = new SourceQuery();

			try {
				$query->Connect(SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE);
				
				$query->SetRconPassword(Helper::setting('rcon_password'));
				
				return $query->Rcon($command);
			} catch (Exception $e) {
				 return $e->getMessage();
			} finally {
				$query->Disconnect();
			}
		} else {
			return false; // TODO error handling
		}
	}
}
