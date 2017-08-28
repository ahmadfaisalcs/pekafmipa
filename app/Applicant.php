<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    //
    public function application()
    {
    	return $this->hasMany('App\Application');
    }

   	public function biodata()
   	{
   		return $this->hasOne('App\Biodata');
   	}

   	public function information()
   	{
   		return $this->hasMany('App\Information');
   	}
}
