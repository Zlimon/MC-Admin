<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;

class StatsPlaytime extends Model
{
	use GeneratesUuid;

	protected $table = 'stats_playtime';

	protected $primaryKey = 'player';

	protected $casts = ['player' => 'uuid'];

    public function uuidColumn(): string
    {
        return 'player';
    }
}
