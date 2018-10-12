<?php

namespace App;

use App\Tag;
use App\Answer;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Question extends Model
{
    protected $fillable = ['body', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
