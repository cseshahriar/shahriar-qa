@extends('layouts.app')  

@section('content')
<div class="container">
    <!-- question -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ $question->title }}</h1>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all Question</a>
                            </div>
                        </div>
                    </div> 
                    <hr> 

                    <div class="media">  
                        <!-- voting -->
                        <div class="d-flex flex-column vote-controls">
                            <a href="#"  title="This question is userful" class="vote-up {{ Auth::guest() ? 'off' : ''}}"
                                onclick="event.preventDefault();document.getElementById('vote-up-{{$question->id}}').submit();"
                            >
                                <i class="fas fa-caret-up fa-3x"></i> 
                            </a>  
                            <form id="vote-up-{{$question->id}}" action="{{ url('/questions/'.$question->id.'/vote') }}" method="POST">    
                                @csrf 
                                <input type="hidden" name="vote" value="1">
                            </form> 
                            <span class="vote-count">{{ $question->votes_count }}</span>  

                            <a href="#"  title="This question is not userful" class="vote-down {{ Auth::guest() ? 'off' : ''}}"
                                onclick="event.preventDefault();document.getElementById('vote-down-{{$question->id}}').submit();"
                            >
                                <i class="fas fa-caret-down fa-3x"></i> 
                            </a>
                             <form id="vote-down-{{$question->id}}" action="{{ url('/questions/'.$question->id.'/vote') }}" method="POST">     
                                @csrf 
                                <input type="hidden" name="vote" value="-1">
                            </form> 



                            <a title="Click to mark as favourite question(Click again to undo)"class="favourite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}" 
                            onclick="event.preventDefault();document.getElementById('favorite-question-{{$question->id}}').submit();"  
                            >
                                <i class="fas fa-heart fa-2x"></i>  
                                <span class="favourite-count">{{ $question->favorites_count }}</span> 
                            </a>   

                            <form id="favorite-question-{{$question->id}}" action="{{ url('/questions/'.$question->id.'/favorites') }}" method="POST">    
                                @csrf 

                                @if($question->is_favorited)
                                    @method('DELETE')    
                                @endif

                            </form>
                        </div>  

                        <div class="media-body"> 
                            {!! $question->body_html !!} 

                              <div class="float-right">
                                    <span class="text-muted">Answered {{ $question->created_date }}</span>

                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url }}" class="pr-2">
                                            <img src="{{ $question->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-1"> 
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div> 
                            
                        </div>

                    </div>
                    
                </div>

            </div>
        </div>
    </div>
    
    @include('answers._index', [
        'answers' => $question->answers, 
        'answersCount' => $question->answers_count
    ])  
    
    @if(Auth::check())
    @include('answers.create')
    @endif
</div>
@endsection
