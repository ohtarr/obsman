<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\obsDevice;
use Illuminate\Support\Facades\Log;

class addDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:addDevice {hostname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a device to Observium';

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
		$confirm = null;
		if(!$check)
		{
			$command = 'php ' . env('OBSERVIUM_ROOT_FOLDER') ."add_device.php " . $hostname;
			shell_exec($command);
			$confirm = obsDevice::where('hostname',$hostname)->first();
			if($confirm)
			{
				$message = "Device ID " . $confirm->device_id . " added successfully!";
				print $message . "\n";
				Log::info($message);
			} else {
				$message = "Device " . $hostname . " Failed to add!";
				print $message . "\n";
				throw new \Exception($message);
			}
		} else {
			$message = "Device " . $hostname . " Failed to Add.  Device already exists!";
			print $message . "\n";
			throw new \Exception($message);
		}
		return $confirm;
    }
}
