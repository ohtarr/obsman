<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class deleteSiteGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:deleteSiteGroup {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a Site group from Observium';

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
        //
    }
}
