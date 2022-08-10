<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

        if($method === 'GET') {
            return [
                'customer_id' => 'required',
            ];
        } else {
            return [
                'customer_id' => 'required',
                'image' => 'required|image|mimes:jpg,png,jpeg|max:4096',
            ];
        }
    }
}
