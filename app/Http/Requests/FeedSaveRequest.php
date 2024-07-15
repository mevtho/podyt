<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'cover_photo' => ['sometimes', 'nullable','mimes:png,jpg,gif','max:2048'],
            'title' => ['required', 'string', 'min:2', 'max:400'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1024'],
            'sources' => ['sometimes', 'array'],
            'sources.*' => ['sometimes', 'string', 'url', 'regex:/https:\/\/www.youtube.com\/playlist\?list=\w+/']
        ];

        // Create a new feed
        if ($this->method() === 'POST') {
            $rules['mode'] = ['required', 'in:podcast,answer'];
        }

        return $rules;
    }

    public function messages() {
        return [
            'sources.*.url' => 'This source is not a valid youtube playlist url',
            'sources.*.regex' => 'This source is not a valid youtube playlist url'
        ];
    }
}
