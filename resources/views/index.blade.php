@extends('layouts.app')

@section('title', trans('faq::messages.title'))

@section('content')
    <div class="container content">
        <h1>{{ trans('faq::messages.title') }}</h1>

        @if($questions->isEmpty())
            <div class="alert alert-info" role="alert">
                {{ trans('faq::messages.empty') }}
            </div>
        @else
            <div class="accordion" id="faq">
                @foreach($questions as $question)
                    <div class="card" id="{{ Str::slug($question->name) }}">
                        <div class="card-header px-3 py-4" id="question-{{ $question->id }}">
                            <a class="collapsed" data-toggle="collapse" href="#answer-{{ $question->id }}" data-target="#answer-{{ $question->id }}" aria-expanded="false" aria-controls="answer-{{ $question->id }}">
                                {{ $question->name }}
                            </a>
                        </div>

                        <div id="answer-{{ $question->id }}" class="collapse" aria-labelledby="question-{{ $question->id }}" data-parent="#faq">
                            <div class="card-body user-html-content">
                                {!! $question->answer !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
