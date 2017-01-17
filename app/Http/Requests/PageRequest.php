<?php

namespace App\Http\Requests;

use App\Models\Category;

class PageRequest extends Request
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
        $model = new Category();

        return [
            'categories' => 'sometimes|array|ids_array:' . serialize($this->categories) . ',' . serialize($model)
        ];
    }
}