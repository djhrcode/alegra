<?php

namespace App\User\Application\Requests;

use App\User\Domain\UserAuthenticable;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirm' => 'required|string|same:password',
        ];
    }

    public function value(): UserAuthenticable
    {
        $data = $this->validated();

        return UserAuthenticable::fromPrimitives(0, $data['name'], $data['email'], $data['password']);
    }
}
