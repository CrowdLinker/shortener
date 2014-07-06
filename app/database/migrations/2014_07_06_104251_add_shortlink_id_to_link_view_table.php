<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShortlinkIdToLinkViewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('link_view', function(Blueprint $table)
		{
			$table->integer('shortlink_id')->unsigned()->index();
            $table->foreign('shortlink_id')->references('id')->on('shortlink')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('link_view', function(Blueprint $table)
		{
			
		});
	}

}
