<?php

namespace App\Http\Requests;

use App\Enums\SpotifyMarket;
use App\Enums\SpotifySearchType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'type' => explode(',', $this->input('type', '')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['required', 'string'],
            'type' => ['required', 'array'],
            'type.*' => [new Enum(SpotifySearchType::class)],
            'market' => ['nullable', 'string', new Enum(SpotifyMarket::class)],
            'limit' => ['nullable', 'integer', 'between:1,50'],
            'offset' => ['nullable', 'integer', 'between:0,1000'],
            'include_external' => ['nullable', 'boolean'],
        ];
    }
}
