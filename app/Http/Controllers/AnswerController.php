<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question)
    {
        Answer::create([
            'body' => request('body'),
            'question_id' => $question->id,
            'user_id' => Auth::user()->id
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }

    public function select(Question $question, Answer $answer)
    {
        $updateSelectBestAnswer = $answer->update(['best_answer' => 1]);

        $question->answers()
            ->where('id', '<>', $answer->id)
            ->update([
                'best_answer' => 0
            ]);

        if($updateSelectBestAnswer){
            return back()->with('msg', 'Now the best answer is '. $answer->user->name .'s answer.');
        } else  {
        return back();
        }
    }
}
