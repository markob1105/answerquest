<?php

namespace App;

use App\User;
use App\Question;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id','question_id', 'body', 'best_answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
