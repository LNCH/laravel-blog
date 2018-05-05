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
                $rules['images.*'] = 'image';

                $maxSize = config("laravel-blog.images.max_upload_size", 0);
                if (is_numeric($maxSize) && $maxSize > 0)
                {
                    $rules['images.*'] .= "|max:$maxSize";
                }

                break;

            case 'PATCH':
                $rules['caption'] = 'nullable|string';
                $rules['alt_text'] = 'nullable|string';
                break;
        }

        return $rules;
    }
}
