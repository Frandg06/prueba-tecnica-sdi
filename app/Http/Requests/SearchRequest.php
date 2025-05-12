<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'type' => ['required', 'array', 'in:album,artist,playlist,track,show,episode,audiobook'],
            'market' => ['nullable', 'string', 'in:AD,AE,AR,AT,AU,BE,BG,BH,BO,BR,CA,CH,CL,CO,CR,CY,CZ,DE,DK,DO,EC,EE,ES,FI,FR,GB,GR,GT,HK,HN,HU,ID,IE,IL,IN,IS,IT,JP,LI,LT,LU,LV,MC,MD,ME,MK,MT,MX,MY,NI,NL,NO,NZ,OM,PA,PE,PH,PL,PT,PY,QA,RO,RS,RU,SA,SE,SG,SI,SK,SV,TH,TR,TW,UA,US,UY,VN,ZA'],
            'limit' => ['nullable', 'integer', 'between:1,50'],
            'offset' => ['nullable', 'integer', 'between:0,1000'],
            'include_external' => ['nullable', 'boolean'],
        ];
    }
}
