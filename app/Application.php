<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
   	public function applicant()
   	{
   		return $this->belongsTo('App\Applicant');
   	}

   	public function information()
   	{
   		return $this->hasOne('App\Information');
   	}
}
