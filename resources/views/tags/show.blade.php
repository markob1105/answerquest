@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-4 m-3 stage">
        <h2>All questions with tag - {{ $tag->name }} :</h2>

        @foreach ($questions as $question)
          @include ('questions.question')
        @endforeach

        <div class="d-flex justify-content-center">
          {!! $questions->render() !!}
        </div>
      </div>
    </div>
  </div>

@endsection