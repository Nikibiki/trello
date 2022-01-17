<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeskStoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
//        dd($this->desk);
        return [
//            'name' => 'required|min:4|max:30|unique:desks',
            'name' => [
                'required',
                'min:4',
                'max:30',
                $this->desk ? Rule::unique('desks')->ignore($this->desk->id) : Rule::unique('desks')
            ]
        ];
    }

    public function messages()
    {
        return [
                'name.required' => 'Поле объязательно для заполнения',
                'name.min' => 'Минимально название должно состоять из 4 символов',
                'name.max' => 'Максимально название должно состоять из 30 символов',
                'name.unique' => 'Данное название уже успользуеся. Придумайте другое.'
        ];
    }

}
