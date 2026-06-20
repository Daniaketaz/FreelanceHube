<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>['string','exists:users,id'],
            'name'=>['string','max:25','min:1'],
            'email'=>['string'],
            'company'=>['string','nullable'],
            'phone'=>['string','max:15'],
            'note'=>['string','nullable']
        ];
    }
}
