<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\obsGroupAssoc;

class obsGroup extends Model
{
	protected $table = 'groups';
    protected $primaryKey = 'group_id';

	public $timestamps = false;

    public function assocs()
    {
        return $this->hasMany('App\obsGroupAssoc', 'group_id', 'group_id');
    }

    public function devices()
    {
        return $this->belongsToMany('App\obsDevice', 'group_table', 'group_id', 'device_id');
    }

	public static function addSiteGroup($sitecode)
	{
		$sitecode = strtoupper($sitecode);
		$assoc = '{"condition":"AND","rules":[{"id":"device.hostname","field":"device.hostname","type":"string","input":"text","operator":"match","value":"' . $sitecode . '*"}],"valid":true}';
		
		$group = new static();
		$group->entity_type = "device";
		$group->group_name = "SITE_".$sitecode;
		$group->group_descr = "Default site group for " . $sitecode;
		$group->group_assoc = $assoc;
		$group->group_menu = 0;
		$group->group_ignore = 0;
		$group->group_ignore_until = 0;
		$group->save();

/* 		$assoc = new obsGroupAssoc;
		$assoc->group_id = $group->group_id;
		$assoc->entity_type = "device";
		$assoc->device_attribs = '[{"attrib":"hostname","condition":"match","value":"' . $sitecode . '*"}]';
		$assoc->entity_attribs = '[{"attrib":"*","condition":null,"value":null}]';
		$assoc->save(); 
		$group->assocs;
*/
		return $group;
	}
	
	public static function findSiteGroup($sitecode)
	{
		$groupname = "SITE_".$sitecode;
		$group = self::where('group_name',$groupname)->first();
		return $group;
	}

	public static function deleteSiteGroup($sitecode)
	{
		$group = self::findSiteGroup($sitecode);
		if($group)
		{
			$group->delete();
			return true;
		}
	}

}
