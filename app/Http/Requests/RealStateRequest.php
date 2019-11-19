<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RealStateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            //'user_id', 
            'title' => 'required', 
            'description' => 'required',
            'content', 
            'price' => 'required',
            'bathrooms',
            'bedrooms',
            //'slug',
            'property_area',
            'total_property_area'
        ];
    }
}
