<?php

namespace App\Http\Requests;

use App\Rules\ValidExpiredDate;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'amount' => ['required', 'integer', 'min:1'],
            'reff' => ['required', 'numeric', 'min:5', 'unique:orders,reff'],
            'expired_at' => ['required', 'dateformat:Y-m-d\TH:i:sP', new ValidExpiredDate],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:16'],
        ];
    }
}
