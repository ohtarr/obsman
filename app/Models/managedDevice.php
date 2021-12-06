<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as GuzzleHttpClient;

class managedDevice extends Model
{
    protected $guarded = [];
    public $category = 'Management';
    public $type = 'Device_Network_Cisco';

    public static function all($columns = [])
    {
        $url = env('MANAGED_DEVICES_URL');
        $client = new GuzzleHttpClient();
        $response = $client->request("GET", $url);
        //get the body contents and decode json into an array.
        $array = json_decode($response->getBody()->getContents(), true);
        $array = $array['devices'];
        foreach($array as $item)
        {
            if($item['name'])
            {
                $object = self::make($item);
                $devices[] = $object;
            }
        }
        return collect($devices);
    }

}
