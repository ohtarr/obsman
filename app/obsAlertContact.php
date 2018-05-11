<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obsAlertContact extends Model
{
	protected $table = 'alert_contacts';
	protected $primaryKey = 'contact_id';

	public function AlertTests()
	{
		return $this->belongsToMany('App\obsAlertTest', 'alert_contacts_assoc', 'contact_id', 'alert_checker_id');
	}
}
