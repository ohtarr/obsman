<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\managedDevice;
use App\Models\obsDevice;
use GuzzleHttp\Client as GuzzleHttpClient;

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
		$this->addDevices();
		//$this->deleteDevices();
		//print_r($this->getObsDevices());
		//print_r($this->getManagedDevices());
		//$this->syncPorts();
		//$this->syncCoords();
		//print_r($this->getManagedDevices());
    }

	public function getManagedDevices()
	{
		if(!$this->managedDevices)
		{
			$verb = 'GET';
			$url = getenv('URL_NETMAN_DEVICES');
			$options = [];
			$params = [];

			$client = new GuzzleHttpClient($options);
			$apiRequest = $client->request($verb, $url, $params);

			$response = json_decode($apiRequest->getBody()->getContents(),true);
			$devices = $response['devices'];

			foreach($devices as $item)
			{
					$model = new managedDevice($item);
					$models[] = $model;
			}
			// return an eloquent collection of models
			$model = new managedDevice();
			$collection = $model->newCollection($models);
			$this->managedDevices = $collection;
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
			$obsdevice = $obsdevices->where('hostname',$device->name)->first();
			if(!$obsdevice)
			{
				print "adding " . $device->name . "\n";
				try
				{
					obsDevice::addDevice($device->name);
					break; //remove me!
				} catch(\Exception $e) {}
				$addeddevice = obsDevice::where('hostname',$device->name)->first();
				if($addeddevice)
				{
					print "Added " . $device->name . " successfully!\n";
				}
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
				obsDevice::deleteDevice($obsdevice->hostname);
				break;  //remove me!
			}
		}
	}

	public function syncPorts()
	{
		print "Getting Managed Devices\n";
		$manageddevices = $this->getManagedDevices();
		print "Getting Obs Devices\n";
		$obsdevices = $this->getObsDevices();
		print "Done getting devices!\n";
		foreach($obsdevices as $obsdevice)
		{
			print $obsdevice->hostname . "\n";
			$manageddevice = $manageddevices->where('name',$obsdevice->hostname)->first();
			if(isset($manageddevice->interfaces))
			{
				print $manageddevice->name . "\n";
				foreach($obsdevice->ports as $port)
				{
					print $port->ifDescr . "\n";
					$managedint = null;
					foreach($manageddevice->interfaces as $intname => $intcfg)
					{
						if(strtolower($port->ifDescr) == strtolower($intname))
						{
							$managedint = $intcfg;
							print "MATCHED INTERFACE: " . $intname . "\n";
							break;
						}
					}
					if($managedint)
					{
						$MON = 0;
						$ALERT = 0;
						if(isset($managedint['description']['MON']))
						{
							if($managedint['description']['MON'] == 1)
							{
								$MON = 1;
							}
						}
						if(isset($managedint['description']['mon']))
						{
							if($managedint['description']['mon'] == 1)
							{
								$MON = 1;
							}
						}
						if($MON == 1)
						{
							if(isset($managedint['description']['ALERT']))
							{
								if($managedint['description']['ALERT'] == 1)
								{
									$ALERT = 1;
								}
							}
							if(isset($managedint['description']['alert']))
							{
								if($managedint['description']['alert'] == 1)
								{
									$ALERT = 1;
								}
							}
						}

						if($MON == 1)
						{
							$port->enablePolling();
						} else {
							$port->disablePolling();
						}

						if($ALERT == 1)
						{
							$port->enableAlerting();
						} else {
							$port->disableAlerting();
						}
					}
				}
			}
		}
	}

	public function syncCoords()
	{
		$obsdevices = $this->getObsDevices();
		foreach($obsdevices as $obsdevice)
		{
			$loc = $obsdevice->loc;
			$snowloc = $obsdevice->getServiceNowLocation();
			if($loc && $snowloc)
			{
				if($snowloc->latitude >= -90 && $snowloc->latitude <= 90 && $snowloc->longitude >= -180 && $snowloc->longitude <= 180)
				{
					if($loc->location_lat != $snowloc->latitude)
					{
						$loc->location_lat = $snowloc->latitude;
						$loc->save();
					}
					if($loc->location_lon != $snowloc->longitude)
					{
						$loc->location_lon = $snowloc->longitude;
						$loc->save();
					}
				} else {
					$loc->location_lat = "37.7463058";
					$loc->location_lon = "-45.0000000";
					$loc->save();
				}
			}
		}
	}

}
