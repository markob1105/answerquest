@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-4 m-3 stage">
        <div class="">
          <div class="card mt-3">
            <div class="card-body">
              @if(Auth::user() == $user)
                <h5 align="center">My profile:</h5>
              @else
                <h5 align="center">{{ $user->name }}'s profile:</h5>
              @endif
              <div class="d-flex justify-content-between py-2">
                <div>
                  <h5>Name: {{ $user->name }}</h5>
                  <h5>Email: {{ $user->email }}</h5>
                </div>
                <div>
                  <div>
                    <img class="img-thumbnail m-3" src="{{ asset('/upload/profile/' . $user->profile_image) }}" alt="">
                  </div>
                  @if(Auth::check())
                  <form method="POST" action="/profile/{{ Auth::user()->id }}/photo" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="file">Post Image</label>
                      <input class="choose-file" type="file" name="file"> </input>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-light">Publish Image</button>
                    </div>
                  </form>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @if(Auth::user() == $user)
            <h5 class="text-center my-3">My questions:</h5>
          @else
            <h5 class="text-center my-3">{{ $user->name }}'s questions:</h5>
          @endif

          @foreach ($questions as $question)
            @include ('questions.questionTopAnswer')
          @endforeach
        </div>

        <div class="d-flex justify-content-center">
          {!! $questions->render() !!}
        </div>

      </div>
    </div>
  </div>
@endsection