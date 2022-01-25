<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WorkingDaysRule implements Rule
{
    private $weekdays = [0, 1, 2, 3, 4, 5, 6];

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
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (sizeof(array_diff(array_keys($value), $this->weekdays)) == 0)
        {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
