<?php 
namespace App\Http\Requests\API\v1;
use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiFormRequest extends FormRequest
{
  use ApiResponseTrait;

   protected function failedValidation(Validator $validator)
    {
        Throw new HttpResponseException($this->error($validator->errors()->all(),422));
    }
}