@extends('layouts.app')

@section('title', trans('faq::messages.title'))

@section('content')
    <h1>{{ trans('faq::messages.title') }}</h1>

    @if($questions->isEmpty())
        <div class="alert alert-info" role="alert">
            {{ trans('faq::messages.empty') }}
        </div>
    @else
        <div class="accordion" id="faq">

            @foreach($questions as $id => $question)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="{{ Str::slug($question->name) }}">
                        <button class="accordion-button @if(!($show = ($id === 0))) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#answer{{ $question->id }}" aria-expanded="false" aria-controls="answer{{ $question->id }}">
                            {{ $question->name }}
                        </button>
                    </h2>
                    <div id="answer{{ $question->id }}" class="accordion-collapse collapse @if($show) show @endif" aria-labelledby="{{ Str::slug($question->name) }}" data-bs-parent="#faq">
                        <div class="accordion-body">
                            {!! $question->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    @endif
@endsection
