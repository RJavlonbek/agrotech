<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class DriverLicence extends Authenticatable
{
	protected $casts=['type'=>'json'];
    
}