<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obsEvent extends Model
{
	protected $table = 'eventlog';
    protected $primaryKey = 'event_id';
    public $timestamps = false;

    public function device()
    {
		return $this->belongsTo('App\obsDevice', 'device_id', 'device_id');
    }

	public function entity()
	{
		switch ($this->entity_type) {
			case 'device':
				$model = new obsDevice;
				$foreignKey = "device_id";
				break;
			case 'bgp_peer':
				$model = new obsBgpPeer;
				$foreignKey = "bgpPeer_id";
				break;
			case 'port':
				$model = new obsPort;
				$foreignKey = "port_id";
				break;			
			default:
				# code...
				break;
		}
        return $this->belongsTo($model, 'entity_id', $foreignKey);
	}


}
