<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Question;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Question $question, User $user) {
        $questions = Question::orderBy('created_at', 'desc')->where('user_id' , $user->id)->paginate(5);

        return view('profile.profile', [
            'questions' => $questions,
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        $name = str_random(10) . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.jpg';
        $profileImage = Image::make($file)->encode('jpg');

        $profileImage->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $profileImage->save(public_path('/upload/profile/' . $name));

        Auth::user()->update([
            'profile_image' => $name
        ]);

        return redirect()->back();
    }

    /**
     * Updates user profile data and processes and stores profile image
     * @param Request $request
     */
    public function update(Request $request)
    {
        // take request input data

        // take request profile photo file

        // update user data

        // process profile photo - generate new file name, encode and optimize for web
        $profileName = $this->processProfileimage($file);

        // save new profile name in database

        // redirect with success
    }

    protected function processProfileImage($file)
    {
        // process profile photo - generate new file name, encode and optimize for web

        return $profileImageName;
    }
}
