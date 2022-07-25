<?php

namespace App\Http\Requests\Admin\ContractList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreContractList extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.contract-list.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'branch_id' => ['required', 'integer'],
            'contract_number' => ['required', 'string'],
            'start_contract_date' => ['required', 'date'],
            'end_contract_date' => ['required', 'date'],
            'partner_id' => ['required', 'integer'],
            'partner_bin' => ['required', 'string'],
            'agent_id' => ['required', 'integer'],
            'pay_status_id' => ['required', 'integer'],
            'pay_type_id' => ['required', 'integer'],
            'agent_fee' => ['required', 'numeric'],
            'enabled' => ['required', 'boolean'],
            
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
