<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TimeValidation implements Rule
{
    public $secondValue;
    public $startDate;
    public $endDate;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($secondValue, $startDate, $endDate)
    {
        $this->secondValue = $secondValue;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
        if( strtotime($this->startDate) == strtotime($this->endDate) ) {
            return strtotime($value) > strtotime($this->secondValue);
        } else return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The start time is greater then the end time.';
    }
}
