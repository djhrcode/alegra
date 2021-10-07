<?php

namespace App\User\Application\Requests;

use App\User\Domain\UserAuthenticable;
use App\User\Domain\UserCredentials;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function value(): UserCredentials
    {
        $data = $this->validated();

        return UserCredentials::fromPrimitives($data['email'], $data['password']);
    }
}
