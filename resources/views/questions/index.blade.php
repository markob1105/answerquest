@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-4 m-3 stage">
        <div class="card my-3">
          <div class="card-body">
            <div class="flex-center">
              @if(Auth::check())
              <form  method="POST" action="/questions">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="body"></label>
                  <textarea class="form-control" id="body" name="body" placeholder="Publish And Ask Your Question"></textarea>
                </div>
                <div class="form-group">
                  <label for="tags">Select or add tag</label>
                  <select name="tags[]" id="tags" class="form-control js-data-example-ajax" multiple="multiple"></select>
                </div>
                <br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-timeline">Publish Your Question</button>
                </div>
              </form>

              @endif

              @if(!Auth::check())
                  Please <a href="{{ route('register') }}">Register</a> yourself for publishing your question or answering on other users questions!
              @endif
            </div>
          </div>
        </div>

        @foreach ($questions as $question)
          @include ('questions.questionTopAnswer')
        @endforeach

        <div class="d-flex justify-content-center">
          {!! $questions->render() !!}
        </div>
      </div>
    </div>
  </div>

@endsection






