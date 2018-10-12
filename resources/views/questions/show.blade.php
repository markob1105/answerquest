@extends('layouts.app')


@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-4 m-3">
        @include ('questions.question')
      </div>
    </div>
  </div>

@endsection