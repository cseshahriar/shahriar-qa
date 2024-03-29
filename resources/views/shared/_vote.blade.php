<!-- voting -->
@if($model instanceOf App\Question)
    @php 
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif ($model instanceOf App\Answer)
    @php 
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

@php 
    $formId = $name . "-" . $model->id;
    $formAction = "/{$firstURISegment }/{$model->id}/vote";    
@endphp 

<div class="d-flex flex-column vote-controls">
    <a href="#"  title="This {{$name}}} is userful" class="vote-up {{ Auth::guest() ? 'off' : ''}}"
        onclick="event.preventDefault();document.getElementById('vote-up-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-up fa-3x"></i> 
    </a>  
    <form id="vote-up-{{$formId}}" action="{{ url('/').$formAction }}" method="POST">    
        @csrf 
        <input type="hidden" name="vote" value="1">
    </form> 
    <span class="vote-count">{{ $model->votes_count }}</span>  

    <a title="This {{$name}} is not userful" class="vote-down {{ Auth::guest() ? 'off' : ''}}"
        onclick="event.preventDefault();document.getElementById('vote-down-{{$formId}}').submit();"
    >
        <i class="fas fa-caret-down fa-3x"></i> 
    </a>
     <form id="vote-down-{{$formId}}" action="{{ url('/').$formAction }}" method="POST">     
        @csrf 
        <input type="hidden" name="vote" value="-1"> 
    </form>  

    
    @if($model instanceOf App\Question)
        @include('shared._favorite', [
            'model' => $model 
        ]) 
    @elseif($model instanceOf App\Answer)
        @include('shared._accept', [
            'model' => $model   
        ]) 
    @endif   
</div>   