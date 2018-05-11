<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\obsDevice;
use Illuminate\Support\Facades\Log;

class deleteDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:deleteDevice {hostname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a device from Observium';

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
		$hostname = $this->argument('hostname');
		$check = obsDevice::where('hostname',$hostname)->first();
		if($check)
		{
			print "Found device " . $check->hostname . " with device_id " . $check->device_id . ".  Deleting device...";
	        $command = 'php ' . env('OBSERVIUM_ROOT_FOLDER') ."delete_device.php " . $hostname . " rrd";
	        shell_exec($command);
			$confirm = obsDevice::find($check->device_id);
			if(!$confirm)
			{
                $message = "Device " . $hostname . " Successfully removed!";
                print $message . "\n";
				Log::info($message);
			} else {
				$message = "Device " . $hostname . " Failed to remove.  Unknown reason!";
				print $message . "\n";
				throw new \Exception($message);
			}
		} else {
				$message = "Device " . $hostname . " Failed to remove.  Device does not exist!";
				print $message . "\n";
				throw new \Exception($message);
		}
    }
}
