<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\obsDevice;

class disableDevicePolling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:disableDevicePolling {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Polling of a device in Observium';

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
		$port = obsDevice::find($id);
		$port->disablePolling();
    }
}
