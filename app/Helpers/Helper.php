<?php

namespace App\Helpers;

use App\ServerSetting;

class Helper
{
	public static function setting($key) {
		$value = ServerSetting::find($key);

		$setting = $value["value"];

		return $setting;
	}

	public static function isServerOnline() {
		$status = self::setting('online');

		if ($status === "true") {
			return true;
		} else {
			return false;
		}
	}
}
