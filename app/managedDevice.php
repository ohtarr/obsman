<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Inarticulate\InformationModel;

class managedDevice extends InformationModel
{
    protected $guarded = [];
    public $category = 'Management';
    public $type = 'Device_Network_Cisco';

}
