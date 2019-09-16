<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	protected $fillable = ['title', 'body']; 

    // every question has one question 
    public function user()
    {
    	return $this->belongsTo(User::class);  
    }
}
