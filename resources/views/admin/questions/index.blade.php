@extends('admin.layouts.admin')

@section('title', trans('faq::admin.questions.title'))

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = Sortable.create(document.getElementById('questions'), {
            animation: 150,
            group: 'question',
            handle: '.sortable-handle'
        });

        function serialize(sortable) {
            return [].slice.call(sortable.children).map(function (child) {
                return child.dataset['id'];
            });
        }

        const saveButton = document.getElementById('save');
        const saveButtonIcon = saveButton.querySelector('.btn-spinner');

        saveButton.addEventListener('click', function () {
            saveButton.setAttribute('disabled', '');
            saveButtonIcon.classList.remove('d-none');

            axios.post('{{ route('faq.admin.questions.update-order') }}', {
                'questions': serialize(sortable.el),
            }).then(function (json) {
                createAlert('success', json.data.message, true);
            }).catch(function (error) {
                createAlert('danger', error.response.data.message ? error.response.data.message : error, true)
            }).finally(function () {
                saveButton.removeAttribute('disabled');
                saveButtonIcon.classList.add('d-none');
            });
        });
    </script>
@endpush

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            @empty($questions)
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i>
                    {{ trans('faq::messages.empty') }}
                </div>
            @else
                <ol class="list-unstyled sortable mb-3" id="questions">
                    @foreach($questions as $question)
                        <li class="sortable-item sortable-dropdown" data-id="{{ $question->id }}">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between">
                                    <span>
                                        <i class="fas fa-arrows-alt sortable-handle"></i>
                                        <span>{{ $question->name }}
                                        </span>
                                    </span>
                                    <span>
                                        <a href="{{ route('faq.admin.questions.edit', $question) }}" class="m-1" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('faq.admin.questions.destroy', $question) }}" class="m-1" title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip" data-confirm="delete"><i class="fas fa-trash"></i></a>
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <button type="button" class="btn btn-success" id="save">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                    <span class="spinner-border spinner-border-sm btn-spinner d-none" role="status"></span>
                </button>
            @endempty

            <a class="btn btn-primary" href="{{ route('faq.admin.questions.create') }}">
                <i class="fas fa-plus"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
