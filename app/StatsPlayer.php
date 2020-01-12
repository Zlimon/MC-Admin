<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;

class StatsPlayer extends Model
{
	use GeneratesUuid;

	protected $primaryKey = 'uuid';

	protected $casts = ['uuid' => 'uuid'];

    public function playtime() {
    	return $this->hasOne(StatsPlaytime::class, 'player');
    }

    public function lastQuit() {
    	return $this->hasOne(StatsLastQuit::class, 'player')->orderBy('id', 'DESC');
    }
}
