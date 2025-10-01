<?php

namespace App\Http\Requests\Task;

use App\Rules\AssigneeRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\v1\ApiFormRequest;

class TaskAssignmentRequest extends ApiFormRequest
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
            'assignee_type'=>'required|in:user,group',
            'assignee_id'=>['required','integer',new AssigneeRule($this->assignee_type)],
        ];
        
    }
}
