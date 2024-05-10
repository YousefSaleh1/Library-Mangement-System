<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:225',
            'description'   => 'required|string',
            'rate'          => 'required|numeric|max:10',
            'publish_date'  => 'required|date',
            'copies_number' => 'required|integer|min:1',
            'author_ids'    => 'required|array',
            'author_ids.*'  => 'exists:authors,id'
        ];
    }
}
