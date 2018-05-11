<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\obsPort;

class disablePort extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:disablePort {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Polling of a port in Observium';

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
		$id = $this->argument('id');
		$port = obsPort::find($id);
		$port->disable();
    }
}
