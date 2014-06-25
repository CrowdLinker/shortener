<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUniqueClicksToShortlinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shortlink', function(Blueprint $table)
		{
			$table->integer(('unique_clicks'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shortlink', function(Blueprint $table)
		{
            $table->dropColumn('unique_clicks');
		});
	}

}
