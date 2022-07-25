<?php

namespace App\Http\Requests\Admin\ContractListMonth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateContractListMonth extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.contract-list-month.edit', $this->contractListMonth);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'contract_list_id' => ['sometimes', 'integer'],
            'month' => ['sometimes', 'integer'],
            'pay_decode' => ['nullable', 'numeric'],
            'pay_act' => ['nullable', 'numeric'],
            'upload_decode_file' => ['nullable', 'string'],
            'download_akt_file' => ['nullable', 'string'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
