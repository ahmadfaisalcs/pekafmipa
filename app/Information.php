<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    //
    public function application()
    {
    	return $this->belongsTo('App\Application');
    }

    public function applicant()
    {
    	return $this->belongsTo('App\Applicant');
    }
}
