<?php

namespace App\User\Application\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class UserName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Str::wordCount($value) > 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "El campo nombre y apellido está incompleto";
    }
}
