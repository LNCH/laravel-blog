<?php

namespace Lnch\LaravelBlog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogTagRequest extends FormRequest
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
        $rules = [];

        switch ($this->method())
        {
            case 'POST':
                $rules['tags'] = 'required|string';
                break;
            case 'PATCH':
                $rules['tag'] = 'required|string';
                break;
        }

        return $rules;
    }
}
