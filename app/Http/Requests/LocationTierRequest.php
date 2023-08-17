<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationTierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:191', Rule::unique('location_tiers', 'name')->ignore($this->route('tier'))],
            'starting' => ['required', 'numeric'],
            'ending' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ];
    }
}
