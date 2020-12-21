@extends('admin.layouts.admin')

@section('title', trans('faq::admin.questions.title-create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('faq.admin.questions.store') }}" method="POST">

                @include('faq::admin.questions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
