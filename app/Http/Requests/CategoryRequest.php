<?php

namespace App\Http\Requests;

use App\Models\Page;

class CategoryRequest extends Request
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
        $model = new Page();

        if ($this->id) {
            return [
                'name'  => 'required|max:255|unique:categories,name,' . $this->id,
                'pages' => 'sometimes|array|ids_array:' . serialize($this->pages) . ',' . serialize($model)
            ];
        }

        return [
            'name'  => 'required|max:255|unique:categories,name',
            'pages' => 'sometimes|array|ids_array:' . serialize($this->pages) . ',' . serialize($model)
        ];
    }
}