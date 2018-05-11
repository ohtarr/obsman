<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\managedDevice;
use App\obsDevice;

class syncDevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:syncDevices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize devices in netman with an external management server';

    /**
     * Create a new command instance.
     *
     * @return void
     */

	public $managedDevices = null;
	public $obsDevices = null;

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
		//$this->addDevices();
		$this->deleteDevices();
    }

	public function getManagedDevices()
	{
		if(!$this->managedDevices)
		{
	        $this->managedDevices = managedDevice::all();
		}
		return $this->managedDevices;
	}

	public function getObsDevices()
	{
		if(!$this->obsDevices)
		{
			$this->obsDevices = obsDevice::all();
		}
		return $this->obsDevices;
	}

	public function addDevices()
	{
		print "Getting Managed Devices\n";
		$manageddevices = $this->getManagedDevices();
		print "Getting Obs Devices\n";
		$obsdevices = $this->getObsDevices();
		print "Done getting devices!\n";
		foreach($manageddevices as $device)
		{
			print $device->name . "\n";
			$obsdevice = $obsdevices->where('hostname',$device->name)->first();
			if(!$obsdevice)
			{
				$this->call('obsman:addDevice', ['hostname' => $device->name]);
			}
		}
	}

	public function deleteDevices()
	{
		$obsdevices = $this->getObsDevices();
		$manageddevices = $this->getManagedDevices();
		foreach($obsdevices as $obsdevice)
		{
			$manageddevice = $manageddevices->where('name',$obsdevice->hostname)->first();
			if(!$manageddevice)
			{
				$this->call('obsman:deleteDevice', ['hostname' => $obsdevice->hostname]);
			}
		}
	}
}
