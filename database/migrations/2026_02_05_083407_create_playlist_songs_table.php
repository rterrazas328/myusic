<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('playlist_songs', function(Blueprint $table)
		{
			//
			$table->unsignedBigInteger('playlist_id');
			$table->foreign('playlist_id')->references('id')->on('playlists');
			$table->unsignedBigInteger('track_id');
			$table->foreign('track_id')->references('band_id')->on('music');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('playlist_songs', function(Blueprint $table)
		{
			//
		});
	}

};
