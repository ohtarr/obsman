<?php

//Example Model to place in your App folder.

namespace App\Models;

use ohtarr\ServiceNowModel;
use GuzzleHttp\Client as GuzzleHttpClient;

class ServiceNowLocation extends ServiceNowModel
{
	protected $guarded = [];

	public $table = "cmn_location";

    public function __construct(array $attributes = [])
    {
        $this->snowbaseurl = env('SNOWBASEURL'); //https://mycompany.service-now.com/api/now/v1/table
        $this->snowusername = env("SNOWUSERNAME");
        $this->snowpassword = env("SNOWPASSWORD");
		parent::__construct($attributes);
    }

}
