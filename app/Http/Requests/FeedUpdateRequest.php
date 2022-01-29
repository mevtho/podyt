<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedUpdateRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'max:400'],
            'slug' => ['required', 'string', 'max:50'],
            'available' => ['required'],
        ];
    }
}
