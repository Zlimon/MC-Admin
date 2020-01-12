<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;

class StatsLastQuit extends Model
{
	use GeneratesUuid;

	protected $table = 'stats_last_quit';

	protected $primaryKey = 'player';

	protected $casts = ['player' => 'uuid'];

    public function uuidColumn(): string
    {
        return 'player';
    }
}
