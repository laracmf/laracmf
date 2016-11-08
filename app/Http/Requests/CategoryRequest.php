<?php

namespace GrahamCampbell\BootstrapCMS\Http\Requests;

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
        if ($this->id) {
            return [
                'name'  => 'required|max:255|unique:categories,name,' . $this->id,
                'pages' => 'sometimes|array'
            ];
        }

        return [
            'name'  => 'required|max:255|unique:categories,name',
            'pages' => 'sometimes|array'
        ];
    }
}