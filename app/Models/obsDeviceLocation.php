<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\obsDevice;

class obsDeviceLocation extends Model
{
	protected $connection = 'mysql-observium';
	protected $table = 'devices_locations';
    protected $primaryKey = 'location_id';
    public $timestamps = false;

    public function device()
    {
        return $this->belongsTo(obsDevice::class, 'device_id', 'device_id');
    }

	public function devices()
	{
		$locs = self::where('location',$this->location)->get();
		foreach($locs as $loc)
		{
			$devices[] = $loc->device;
		}
		return collect($devices);
	}

}
