<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Validator;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        Validator::extend('unique_email', function ($attribute, $value, $parameters) {
            //dd($value, $attribute, $parameters);
            $user = User::where('email', $value)->where('id', '!=', $parameters[0])->whereNull('deleted_at')->count();
            if ($user != 0) {
                return false;
            } else {
                return true;
            }
        }, 'Email id is already exists.');
        return [
            'user_name' => ['string', 'max:255'],
            'image' => ['file', 'mimes:png,jpg,jpeg,ico,bmp', 'max:1024'],
            'email' => ['email', 'max:255', 'unique_email:'.$this->user()->id],
        ];
    }
}
