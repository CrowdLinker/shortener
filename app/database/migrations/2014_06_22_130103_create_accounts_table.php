<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');
            $table->string('token');
            $table->string('secret')->nullable()->default(NULL);
            $table->integer('expiry')->nullable()->default(NULL);
            $table->string('provider');
            $table->string('facebook_id')->nullable()->default(NULL);
            $table->string('twitter_id')->nullable()->default(NULL);
            $table->integer('user_id')->unsigned()->index();
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
		Schema::drop('accounts');
	}

}
