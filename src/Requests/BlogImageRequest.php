<?php

namespace Lnch\LaravelBlog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogImageRequest extends FormRequest
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
        $rules = [
            'description' => 'sometimes|string'
        ];

        switch ($this->method())
        {
            case 'POST':
                $rules['images'] = 'required|array';
                break;
            case 'PATCH':
                $rules['caption'] = 'sometimes|string';
                $rules['alt_text'] = 'sometimes|string';
                break;
        }

        return $rules;
    }
}
