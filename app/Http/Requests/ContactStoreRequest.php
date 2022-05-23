<?php

namespace App\Http\Requests;

use App\Rules\Tenant\TenantUnique;
use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            "name"=>"nome",
            "number"=>"número",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                new TenantUnique('contact'),
            ],
            'number' => [
                'required',
                'string',
                'max:255',
                new TenantUnique('contact'),
            ],
        ];
    }
}
