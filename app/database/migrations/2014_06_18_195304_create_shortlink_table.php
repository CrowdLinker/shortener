<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShortlinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shortlink', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');
            $table->longText('url');
            $table->longText('pagetitle');
            $table->string('domainprovider');
            $table->string('hash');
            $table->integer('clicks');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shortlink');
	}

}
