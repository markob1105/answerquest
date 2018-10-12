<div class="card mb-3 question-card">

    <div class="d-flex">

      <div>
        <img class="img-thumbnail m-3 p-image" src="{{ asset('/upload/profile/' . $question->user->profile_image) }}" alt="">
      </div>

      <div class="m-4 name-big" >
        <a href="/profile/{{ $question->user->id }}">
          <h4 id="user-name">{{ $question->user->name }}</h4>
        </a>
        <a href="/questions/{{ $question->id }}">
          <p class="meta time">on {{ $question->created_at->toDayDateTimeString() }}</p>
        </a>
      </div>

    </div>

    <div  class="question-index">
      <h3 class="title">{{ $question->body }}</h3>

      @if( $question->created_at->addMinutes(10) >= now() )
        @if(Auth::user()->id === $question->user_id)
          <a href="/questions/{{ $question->id }}/edit" class="btn btn-sm btn-dark pull-right">Edit</a>
        @endif
      @endif

      @if($question->tags->count())
        <p class="p-tags">
          Tags:
            @foreach ($question->tags as $tag)
              <a class="tags" href="/tag/{{ $tag->id }}">
                {{ $tag->name }}
              </a>
            @endforeach
        </p>
      @else
        <p>No tags for this question</p>
      @endif
    </div>

    <div class="answer">
      <p class="answers-title">Answers:</p>
      <ul Class="list-group">
        @foreach ($question->answers as $answer)

          @if($answer->best_answer === 1)
            <li class="list-group-item answer-item">
              <div class="card-body answercard">
                <div class="d-inline-flex">
                  <p class="best-answer"><i class="fas fa-star"></i> best answer </p>
                </div>
                <div class="d-flex m-2">
                  <div class="">
                    <img class="img-thumbnail ba-image" src="{{ asset('/upload/profile/' . $answer->user->profile_image) }}" alt="">
                  </div>  {{--<div class="d-flex" style="flex-flow: column-reverse wrap-reverse; align-content: space-between;">--}}
                  <div class="user-name-time">
                    <p><a class="best-answer" href="/profile/{{ $answer->user_id }}">{{ $answer->user->name }}</a></p>
                    <p><strong>{{ $answer->created_at->diffForHumans() }} :</strong></p>
                  </div>
                </div>
              </div>
              <p class="best-answer b-a-body" style="">{{ $answer->body }}</p>
            </li>

          @endif

        @endforeach

          @if(Auth::check())
            <form method="POST" action="/questions/{{$question->id}}/answers">
              {{ csrf_field() }}
              <div class="form-group" id="oya-form">
                <textarea name="body" placeholder="Your answer here." class="form-control"></textarea>
              </div>
              <button type="submit" id="oya-btn" class="btn btn-primary">Offer Your Answer</button>
            </form>
          @endif

        Other Answers:
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
                  <input type="submit" id="sba-btn" class="btn btn-success" value="Select best answer">
                </form>
              @endif
            </li>
          @endif
        @endforeach
      </ul>



    </div>
</div>





