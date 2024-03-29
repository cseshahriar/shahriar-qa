<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use VotableTrait;
    
	protected $fillable = ['title', 'body']; 

    // every question has one question 
    public function user()
    {
    	return $this->belongsTo(User::class);  
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value; 
        $this->attributes['slug'] = Str::slug($value); 
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()  
    {
        return $this->created_at->diffForHumans(); 
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered"; 
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);   
    }

    // every question has many answer 
    public function answers() 
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $anser)
    {
        $this->best_answer_id = $anser->id;
        $this->save();   
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); // 'user_id', 'question_id'  
    } 

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0; 
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();  
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count(); 
    }
} 
