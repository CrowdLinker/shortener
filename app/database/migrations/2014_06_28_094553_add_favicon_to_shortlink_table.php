<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFaviconToShortlinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shortlink', function(Blueprint $table)
		{
			$table->string('favicon')->nullable()->default(NULL);
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
            $table->dropColumn('favicon');
		});
	}

}
