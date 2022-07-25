<?php

namespace App\Http\Requests\Admin\ContractList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateContractList extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.contract-list.edit', $this->contractList);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'branch_id' => ['sometimes', 'integer'],
            'contract_number' => ['sometimes', 'string'],
            'start_contract_date' => ['sometimes', 'date'],
            'end_contract_date' => ['sometimes', 'date'],
            'partner_id' => ['sometimes', 'integer'],
            'partner_bin' => ['sometimes', 'string'],
            'agent_id' => ['sometimes', 'integer'],
            'pay_status_id' => ['sometimes', 'integer'],
            'pay_type_id' => ['sometimes', 'integer'],
            'agent_fee' => ['sometimes', 'numeric'],
            'enabled' => ['sometimes', 'boolean'],
            
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
