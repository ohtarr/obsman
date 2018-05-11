<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\obsPort;
use App\obsAlert;
use App\obsBgpPeer;
use App\obsEvent;
use App\obsGroup;


class obsDevice extends Model
{
	protected $table = 'devices';
    protected $primaryKey = 'device_id';
	public $timestamps = false;

	public function ports()
	{
		return $this->hasMany('App\obsPort', 'device_id', 'device_id');
	}

    public function alerts()
    {
        return $this->hasMany('App\obsAlert', 'device_id', 'device_id');
    }

    public function bgpPeers()
    {
        return $this->hasMany('App\obsBgpPeer', 'device_id', 'device_id');
    }

    public function events()
    {
        return $this->hasMany('App\obsEvent', 'device_id', 'device_id');
    }

    public function getActiveAlerts()
    {
        //return obsAlert::where("device_id",$this->device_id)->where("alert_status",0)->get();
		return $this->alerts()->where("alert_status",0)->get();
    }

    public function groups()
    {
        return $this->belongsToMany('App\obsGroup', 'group_table', 'device_id', 'group_id');
    }

    public function loc()
    {
        return $this->belongsTo('App\obsDeviceLocation', 'device_id', 'device_id');
    }

	public function getPort($portname)
	{
		$port = $this->ports()->where('ifDescr',$portname)->first();
		if($port)
		{
			return $port;
		} else {
			$port = $this->ports()->where('ifName',$portname)->first();
			if($port)
			{
				return $port;
			}
		}
			return null;
	}

    public function pollingEnable()
    {
        $this->disabled = 0;
        $this->save();
        $fresh=$this->fresh();
        if($fresh->disabled !== 0)
        {
            throw new Exception("Port ID " . $this->port_id . " failed to enable!");
        }
        return true;
    }

    public function pollingDisable()
    {
        $this->disabled=1;
        $this->ignore=1;
        $this->save();
        $fresh = $this->fresh();
        if($fresh->disabled !== 1 || $fresh->ignore !== 1)
        {
            throw new Exception("Port ID " . $this->port_id . " failed to disable!");
        }
        return true;
    }

    public function AlertingEnable()
    {
        $this->ignore = 0;
        $this->save();
        $fresh=$this->fresh();
        if($fresh->ignore !== 0)
        {
            throw new Exception("Port ID " . $this->port_id . " failed to unignore!");
        }
        return true;
    }

    public function AlertingDisable()
    {
        $this->ignore = 1;
        $this->save();
        $fresh=$this->fresh();
        if($fresh->ignore !== 1)
        {
            throw new Exception("Port ID " . $this->port_id . " failed to ignore!");
        }
        return true;
    }

    public function resetAllAlerts()
    {
        $alerts = $this->getActiveAlerts();
        foreach($alerts as $alert)
        {
			$alert->reset();
        }
		return true;
    }
}

