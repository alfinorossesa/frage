<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        if (auth()->check() == true) {
            return [
                'answer' => 'required'
            ];
        }

        return [
            'answer' => 'required',
            'name' => 'required',
            'email' => 'required'
        ];
    }
}
