<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\User;

class Status extends Model
{
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function likes()
    {
    	return $this->hasMany(Like::class);
    }

    public function like()
    {
		$this->likes()->firstOrCreate([
    		'user_id' => auth()->id()
    	]);
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}
