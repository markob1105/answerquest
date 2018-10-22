<div class="card mb-3 question-card">

    <div class="d-flex align-items-center">

      <div>
        <img class="img-thumbnail m-1 p-image" style="" src="{{ asset('/upload/profile/' . $question->user->profile_image) }}" alt="">
      </div>

      <div class="ml-2 name-big" >
        <a id="user-name-question" href="/profile/{{ $question->user->id }}">
          {{ $question->user->name }}
        </a>
        <br>
        <a id="user-time-question" href="/questions/{{ $question->id }}">
          on {{ $question->created_at->toDayDateTimeString() }}
        </a>
      </div>

    </div>

    <div  class="question-index">
      <p class="title">{{ $question->body }}</p>

      @if( Auth::user() && Auth::user()->id === $question->user_id && $question->created_at->addMinutes(10) >= now() )
        <a href="/questions/{{ $question->id }}/edit" id="btn-edit" class="btn btn-sm btn-dark pull-right">Edit</a>
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
                      <img class="img-thumbnail ba-image" src="{{ asset('/upload/profile/' . $answer->user->profile_image) }}">
                    </div>
                    <div class="user-name-time">
                      <p ><a href="/profile/{{ $answer->user_id }}">{{ $answer->user->name }}</a></p>
                      <p><strong>{{ $answer->created_at->diffForHumans() }} :</strong></p>
                    </div>
                  </div>
               </div>
              <p class="b-a-body">{{ $answer->body }}</p>
            </li>

          @endif

        @endforeach

      </ul>

    </div>

</div>