<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obsBgpPeer extends Model
{
	protected $table = 'bgpPeers';
    protected $primaryKey = 'bgpPeer_id';



	public function device()
	{
        return $this->belongsTo('App\obsDevice', 'device_id', 'device_id');
	}

	public function peer()
	{
        return $this->belongsTo('App\obsDevice', 'peer_device_id', 'device_id');
	}

}
