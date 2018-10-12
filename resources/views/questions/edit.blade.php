@extends('layouts.app')


@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-4 m-3">
        <div class="card card-header">

          <div class="card mb-3">
            <div class="card-body">

              <form  method="POST" action="/questions/{{ $question->id }}">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PATCH">
                  <fieldset>
                    Edit your question:
                    <div class="form-group">
                      <textarea class="form-control" id="body" name="body" placeholder="Publish And Ask Your Question">{{ $question->body }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="tags">Select or add tag</label>
                      <select name="tags[]" id="tags" class="form-control js-data-example-ajax" multiple="multiple">
                        @foreach($question->tags as $tag)
                          <option value="{{ $tag->id }}" selected="selected">{{ $tag->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <br>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-timeline">Save Changes To Your Question</button>
                    </div>
                  </fieldset>
              </form>

              <h4 id="user-name"><a href="/profile/{{ $question->user->id }}">{{ $question->user->name }} </a></h4>
              <a href="/questions/{{ $question->id }}">
                <h3 class="title">{{ $question->body }}</h3>
              </a>

              @if($question->tags->count())
                <p style="color:green">
                  Tags:
                  @foreach ($question->tags as $tag)
                    <a href="#">
                      {{ $tag->name }}
                    </a>
                  @endforeach
                </p>
              @else
                <p>No tags for this question</p>
              @endif

              <p class="meta time">on {{ $question->created_at->toRfc850String() }}</p>

              <div class="answer">
                <p class="answers-title">Answers:</p>
                <ul Class="list-group">
                  @foreach ($question->answers as $answer)

                    @if($answer->best_answer === 1)
                      <li class="list-group-item answer-item">
                        <p class="best-answer">best answer </p>
                        <strong>{{ $answer->created_at->diffForHumans() }} </strong>by <a class="best-answer"
                                                                                          href="/profile/{{ $answer->user_id }}">{{ $answer->user->name }}: </a>
                        <p class="best-answer b-a-body">{{ $answer->body }}</p>

                      </li>
                    @endif

                  @endforeach


                  @foreach ($question->answers as $answer)
                    @if($answer->best_answer !== 1)
                      <li class="list-group-item answer-item">
                        <strong>{{ $answer->created_at->diffForHumans() }} </strong>by <a
                            href="/profile/{{ $answer->user_id }}">{{ $answer->user->name }}: </a>
                        {{ $answer->body }} <br>

                        @if (Auth::check() && $question->user_id === Auth::user()->id)
                          <form action="{{ route('questions.answer.select', ['question' => $question, 'answer' => $answer]) }}"
                                method="POST"
                                style="display: inline-block;">
                            {!! csrf_field() !!}
                            <input type="submit" class="btn btn-success" value="Select best answer">
                          </form>
                        @endif
                      </li>
                    @endif
                  @endforeach
                </ul>

                @if(Auth::check())
                  <form method="POST" action="/questions/{{$question->id}}/answers">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <textarea name="body" placeholder="Your answer here." class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-timeline">Offer Your Answer</button>
                  </form>
                @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection