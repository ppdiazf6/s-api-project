<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
	protected $fillable = [
        'user_id',
        'title',
        'content'
    ];
	
	//
	public function scopeTitle($query, $title)
    {
        if ($title) {
            $query->where('title','like',"%{$title}%");
        }
    }

    public function scopeUser($query, $userId)
    {
        if ($userId) {
            $query->where('user_id',$userId);
        }
    }
	//
	
	/* RELATIONS */
	public function user()
    {
        return $this->belongsTo(User::class);
    }
}
