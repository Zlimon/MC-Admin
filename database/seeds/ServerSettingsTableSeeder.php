<?php

use Illuminate\Database\Seeder;

class ServerSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('server_settings')->insert([
			["key" => "host", "value" => "mc.habski.me"],
			["key" => "port", "value" => "25565"],
			["key" => "rcon_host", "value" => "mc.habski.me"],
			["key" => "rcon_port", "value" => "25575"],
			["key" => "rcon_password", "value" => "test123"],
			["key" => "online", "value" => "true"],
		]);
	}
}
