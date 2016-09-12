<?php

namespace Confee\Units\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 * @package Confee\Units\Authentication\Http\Requests
 */
class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}