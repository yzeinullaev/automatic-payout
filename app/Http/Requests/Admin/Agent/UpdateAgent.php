<?php

namespace App\Http\Requests\Admin\Agent;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAgent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.agent.edit', $this->agent);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'initials' => ['sometimes', 'string'],
            'iin' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'requisite' => ['sometimes', 'string'],
            'partner_id' => ['sometimes', 'integer'],
            'perex' => ['nullable', 'string'],
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

        if (isset($sanitized['publish_now']) && $sanitized['publish_now'] === true) {
            $sanitized['published_at'] = Carbon::now();
        }

        if (isset($sanitized['unpublish_now']) && $sanitized['unpublish_now'] === true) {
            $sanitized['published_at'] = null;
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
