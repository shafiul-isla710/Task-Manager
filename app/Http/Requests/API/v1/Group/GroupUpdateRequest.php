<?php

namespace App\Http\Requests\API\v1\Group;

use App\Http\Requests\API\v1\ApiFormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends ApiFormRequest
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
            'name'=>['sometimes','required','string','max:255',Rule::unique('groups','name')->ignore($this->group->id)],
            'title'=>['sometimes','nullable','string','max:255'],
            'status'=>['sometimes','nullable','boolean','in:1,0'],
        ];
    }
}
