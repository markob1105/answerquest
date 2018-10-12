<?php


namespace App\Http\Controllers;

use App\Tag;
use App\Question;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $tags = Tag::all();
        $questions = $tag->questions()->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tags.show', [
            'tag' => $tag,
            'questions' => $questions,
            'tags' => $tags
        ]);
    }

}


