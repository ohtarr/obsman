<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\obsDevice;

class disableDeviceAlerting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:disableDeviceAlerting {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Alerting of a device in Observium';

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
        $device = obsDevice::find($id);
		try{
	        $device->disableAlerting();
		} catch(Exception $e) {
			print "Failed with exception " . $e->getMessage();
		}
    }
}
