<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use App\Tag;
use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('created_at', 'desc')->paginate(10);

        $tags = Tag::all();

        return view('questions.index', [
            'questions' => $questions
        ])->withTags($tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $tags = $request->get('tags');
        /*$this->validate($request,[
            'name' => 'required'
        ]);*/

        $question = Question::create([
            'body' => request('body'),
            'user_id' => Auth::user()->id
        ]);

        // iteriraj tags array
        if ($tags) {
            $tagIds = [];

            foreach ($tags as $tag) {
                // provjeri je li tag ID ili string. ako je string, spremi ga u bazu i uzmi njegov ID. ako je ID, uzmi njegov ID
                if (is_numeric($tag) && Tag::find((int)$tag)) {
                    $tagIds[] = (int)$tag;
                } else {
                    $newTag = Tag::create([
                        'name' => $tag
                    ]);

                    $tagIds[] = $newTag->id;
                }
            }

            $question->tags()->sync($tagIds);
        }



        return redirect()->action(
            'QuestionController@show', ['question' => $question]
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('questions.show', [
            'question' => $question,
        ]);
    }

    public function showTopAnswer(Question $question)
    {
        return view('questions.showTopAnswer', [
            'question' => $question,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //$this->authorize('update-question', $question);
        if($question->created_at->addMinutes(10) >= now()) {

            if ($question->user_id !== Auth::user()->id) {
                Session::flash('message', "You Are Not Allowed To Edit This Question!");
                return redirect('home'); //->with('msg', 'You are not allowed to edit this question!');
            }
            return view('questions.edit', [
                'question' => $question,
            ]);
        }

        Session::flash('message', "Your Time For Editing This Question Is Up!");
        return redirect('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        if($question->created_at->addMinutes(10) >= now()) {


            if ($question->user_id !== Auth::user()->id) {
                Session::flash('message', "You Are Not Allowed To Edit This Question!");
                return redirect('home'); //->with('msg', 'You are not allowed to edit this question!');
            }

            $this->validate($request, [
                'body' => 'required'
            ]);

            $question->body = $request->body;

            $tags = $request->get('tags', []);
            $tagIds = [];

            foreach ($tags as $tag) {
                if (is_numeric($tag) && Tag::find((int)$tag)) {
                    $tagIds[] = (int)$tag;
                } else {
                    $newTag = Tag::create([
                        'name' => $tag
                    ]);

                    $tagIds[] = $newTag->id;
                }

            }

            $question->tags()->sync($tagIds);

            $question->save();

            return redirect()->route('questions.show', $question);
        }

        Session::flash('message', "Your Time For Editing This Question Is Up!");
        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
