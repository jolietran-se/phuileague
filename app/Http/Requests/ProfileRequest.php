<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        return [
            'username' => 'bail|required|alpha|min:6|max:30',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|numeric|digits_between:9,11',
            'facebook_link' => 'bail|active_url',
            'avatar' => 'bail|image',
        ];
    }

}
