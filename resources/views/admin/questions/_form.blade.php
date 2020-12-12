@csrf

@php
    $translations = $question->translations ?? [];
    $locales = array_keys($translations['name'] ?? []);
@endphp

@push('footer-scripts')
    <script>
        numberOfTranslatedElements = parseInt({{count($locales)}});

        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.command-remove').forEach(function (el) {
            addCommandListenerToTranslations(el);
            });

            document.getElementById('addCommandButton').addEventListener('click', function () {
            
            let form = `
            <div class="form-group">
                <label for="translationInput-`+numberOfTranslatedElements+`">Translation</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="translationInput-`+numberOfTranslatedElements+`" name="translations[`+numberOfTranslatedElements+`][locale]" value="" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger command-remove" type="button"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="nameInput-`+numberOfTranslatedElements+`">{{ trans('messages.fields.name') }}</label>
                <input type="text" class="form-control" id="nameInput-`+numberOfTranslatedElements+`" name="translations[`+numberOfTranslatedElements+`][name]" value="" required>
            </div>

            <div class="form-group">
                <label for="textArea-`+numberOfTranslatedElements+`">{{ trans('messages.fields.answer') }}</label>
                <textarea class="form-control" id="textArea-`+numberOfTranslatedElements+`" name="translations[`+numberOfTranslatedElements+`][answer]" rows="5"></textarea>
            </div>
            `;

            addNodeToTranslationsDom(form);
            });
        });
    </script>
@endpush


<div id="translations">
@forelse ($locales as $locale)
    <div>
        <div class="form-group">
            <label for="translationInput-{{$loop->index}}">Translation</label>
            <div class="input-group">
                <input type="text" class="form-control" id="translationInput-{{$loop->index}}" name="translations[{{$loop->index}}][locale]" value="{{ old('translations.'.$loop->index.'.locale', $locale ?? '') }}" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-danger command-remove" type="button"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    
        <div class="form-group">
            <label for="nameInput-{{$loop->index}}">{{ trans('messages.fields.name') }}</label>
            <input type="text" class="form-control @error('name-'.$loop->index) is-invalid @enderror" id="nameInput-{{$loop->index}}" name="translations[{{$loop->index}}][name]" value="{{ old('translations.'.$loop->index.'.name', $translations['name'][$locale] ?? '') }}" required>
    
            @error('name-'.$loop->index)
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="textArea-{{$loop->index}}">{{ trans('faq::messages.fields.answer') }}</label>
            <textarea class="form-control html-editor @error('answer-'.$loop->index) is-invalid @enderror" id="textArea-{{$loop->index}}" name="translations[{{$loop->index}}][answer]" rows="5">{{ old('translations.'.$loop->index.'.answer', $translations['answer'][$locale] ?? '') }}</textarea>

            @error('answer-'.$loop->index)
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
@empty
<div class="form-group">
    <label for="translationInput-default">Translation</label>
    <input type="text" class="form-control" id="translationInput-default" name="translations[default][locale]" value="{{ old('translations.default.locale', app()->getLocale()) }}" required>
</div>

<div class="form-group">
    <label for="nameInput-default">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name-default') is-invalid @enderror" id="nameInput-default" name="translations[default][name]" value="{{ old('translations.default.name', '') }}" required>

    @error('name-default')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="textArea-default">{{ trans('messages.fields.answer') }}</label>
    <textarea class="form-control html-editor @error('answer-default') is-invalid @enderror" id="textArea-default" name="translations[default][answer]" rows="5">{{ old('translations.default.answer', '') }}</textarea>

    @error('answer-default')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

@endforelse
</div>

<button type="button" id="addCommandButton" class="btn btn-sm btn-success my-2">
    <i class="fas fa-plus"></i> {{ trans('messages.actions.add') }}
</button>
