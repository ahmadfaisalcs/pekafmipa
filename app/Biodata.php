<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    //
    public function applicant()
    {
    	return $this->belongsTo('App\Applicant');
    }
}
