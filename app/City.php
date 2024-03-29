<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function state()
    {
    	return $this->belongsTo(State::class);
    }
    
	public function addresses()
	{
		return $this->hasMany(Address::class);
	}
}
