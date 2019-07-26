<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Pstore extends FormRequest
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
        // return [
        //     'name' => 'required|max:50',
        //     'quantity' => 'required|max:100',
        //     'price' => 'required|max:100',
        //     'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'images' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ];
        $rules = [
            'name' => 'required|max:50',
            'quantity' => 'required|max:100',
            'price' => 'required|max:100',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $photos = count($this->input['photos']);
        foreach(range(0, $photos) as $index) {
            $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
        }

        return $rules;
    }
}
