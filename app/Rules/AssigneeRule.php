<?php

namespace App\Rules;

use App\Models\Group;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AssigneeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $type;
    public function __construct($type)
    {
        $this->type = $type;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->type === 'user') {
            if (!User::where('id', $value)->exists()) {
                $fail('The selected '.$attribute.' is not a valid user.');
            }
        } elseif ($this->type === 'group') {
            if (!Group::where('id', $value)->exists()) {
                $fail('The selected '.$attribute.' is not a valid group.');
            }
        } else {
            $fail('The '.$attribute.' is invalid. It must be either "user" or "group".');
        }
    }
}
