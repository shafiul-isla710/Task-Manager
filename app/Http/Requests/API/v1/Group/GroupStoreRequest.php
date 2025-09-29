<?php

namespace App\Http\Requests\API\v1\Group;

use App\Http\Requests\API\v1\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends ApiFormRequest
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
            'name'=>'required|string|unique:groups,name',
            'title'=>'nullable|string',
            'status'=>'nullable|boolean|in:0,1'
        ];
    }
}
