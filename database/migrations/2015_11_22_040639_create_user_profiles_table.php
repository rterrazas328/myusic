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
		Schema::create('user_profiles', function(Blueprint $table)
		{
			//['address', 'city', 'state', 'country', 'birthdate', 'phone', 'profile_picture', 'about_me']
			$table->unsignedBigInteger('id');
			$table->foreign('id')->references('id')->on('users');
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('country')->nullable();
			$table->date('birthdate')->nullable();
			$table->string('phone')->nullable();
			$table->string('profile_picture')->nullable();
			$table->text('about_me')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_profiles');
	}

};
