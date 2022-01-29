<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedStoreRequest extends FormRequest
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
            'cover_photo' => ['sometimes', 'nullable','mimes:png,jpg,gif','max:2048'],
            'sources' => ['sometimes', 'array'],
            'sources.*' => ['sometimes', 'string', 'url', 'regex:/https:\/\/www.youtube.com\/playlist\?list=\w+/']
        ];
    }

    public function messages() {
        return [
            'sources.*.url' => 'The source is not a valid youtube playlist url',
            'sources.*.regex' => 'The source is not a valid youtube playlist url'
        ];
    }
}
