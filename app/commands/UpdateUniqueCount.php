<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateUniqueCount extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'crowdlinker:updatecount';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates unique count field of shortlink table.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$views = LinkView::all()->toArray();
        $count = array_fetch($views, 'shortlink_id');
        $final = array_count_values($count);
        foreach($final as $key=>$value)
        {
            $shortlink = ShortLink::where('id','=',$key)->first();
            $unique_clicks = $shortlink->unique_clicks + $value;
            $shortlink->unique_clicks = $unique_clicks;
            $shortlink->save();
        }
        LinkView::truncate();
        $this->info('Unique Click column updated !');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
