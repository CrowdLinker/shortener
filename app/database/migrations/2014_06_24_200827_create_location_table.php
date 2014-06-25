<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('location', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('city');
            $table->string('country');
            $table->string('ip');
            $table->integer('shortlink_id')->unsigned()->index();
            $table->foreign('shortlink_id')->references('id')->on('shortlink')->onDelete('cascade');
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
		Schema::drop('location');
	}
}
