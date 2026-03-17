<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidExpiredDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $expiredDate = Carbon::parse($value);

            if ($expiredDate->lessThan(Carbon::now()->addMinutes(3))) {
                $fail('The :attribute must be a future date.');
            }

        } catch (\Exception $e) {
            $fail('The :attribute must be a valid date in ISO 8601 format.');
        }
    }
}
