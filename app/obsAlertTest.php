<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obsAlertTest extends Model
{
	protected $table = 'alert_tests';
    protected $primaryKey = 'alert_test_id';

    public function alerts()
    {
        return $this->hasMany('App\obsAlert', 'alert_test_id', 'alert_test_id');
    }

	public function alertContacts()
	{
		return $this->belongsToMany('App\obsAlertContact', 'alert_contacts_assoc', 'alert_checker_id', 'contact_id');
	}
}
