<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obsGroupAssoc extends Model
{
	protected $table = 'groups_assoc';
    protected $primaryKey = 'group_assoc_id';
	public $timestamps = false;

    public function group()
    {
        return $this->belongsTo('App\obsGroup', 'group_id', 'group_id');
    }

}

