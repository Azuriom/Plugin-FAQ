<?php

namespace Azuriom\Plugin\FAQ\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'translations.*.name' => ['required', 'string', 'max:100'],
            'translations.*.answer' => ['required', 'string'],
            'translations.*.locale' => ['required', 'string'],
        ];
    }
}
