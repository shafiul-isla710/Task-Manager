<?php

namespace App\Http\Requests\API\v1\Auth;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\v1\ApiFormRequest;

class ProfileUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['sometimes','required','string','max:255'],
            'email'=>['sometimes','required','string','email','max:255',Rule::unique('users','email')->ignore($this->user()->id)],
            'password'=>['sometimes','required','string','min:8'],
        ];
    }
}
