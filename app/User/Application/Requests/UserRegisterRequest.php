<?php

namespace App\User\Application\Requests;

use App\User\Application\Rules\UserName;
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
            'name' => ['required', 'string', 'max:255', new UserName],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirm' => ['required', 'string', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Ingrese un nombre y apellido válidos',
            'name.required' => 'Ingrese un correo electrónico válido',
            'name.max' => 'Wow ¿ese es tu nombre? Lo sentimos, es muy largo',

            'email.string' => 'Ingrese un correo electrónico válido',
            'email.email' => 'Ingrese un correo electrónico válido',
            'email.required' => 'Ingrese un correo electrónico válido',
            'email.max' => 'Wow ¿ese es tu correo? Lo sentimos, es muy largo',

            'password.required' => 'Ingrese una contraseña válida',
            'password.string' => 'Ingrese una contraseña válida',
            'password.min' => 'La contraseña debe tener al menos 8 carácteres',

            'password_confirm.required' => 'Ingrese una contraseña de confirmación',
            'password_confirm.string' => 'Ingrese una contraseña de confirmación válida',
            'password_confirm.same' => 'Las contraseñas ingresadas no coinciden',
        ];
    }

    public function value(): UserAuthenticable
    {
        $data = $this->validated();

        return UserAuthenticable::fromPrimitives(0, $data['name'], $data['email'], $data['password']);
    }
}
