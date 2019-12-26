<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TimeValidation implements Rule
{
    public $secondValue;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($secondValue)
    {
        $this->secondValue = $secondValue;
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
        return $value > $this->secondValue;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Lets try this.';
    }
}
