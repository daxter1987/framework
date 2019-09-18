<?php

namespace daxter1987\Framework\Commands;

use Illuminate\Console\Command;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dax:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates composer file in project to be able to use classes and components in vendor folder';

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
    public function handle()
    {
        echo "Started create command\n";



        echo "End create command\n";
    }
}
