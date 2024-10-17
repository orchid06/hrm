<?php

namespace App\Http\Requests\Admin;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveTypeRequest extends FormRequest
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
        $leaveTypeId = request()->input('id');

        return [
            'name'      =>  ['required','string','max:191', Rule::unique('leave_types')->ignore($leaveTypeId),],
            'days'      => 'nullable|integer|min:1',
            'is_paid'   => ['required', Rule::in(StatusEnum::toArray())],
            'status'    => ['required', Rule::in(StatusEnum::toArray())],
        ];
    }

    public function messages(): array
    {
        return[
            'name.unique' => translate('The Type already exists'),
            'days.min'    => translate('Days must have a minimum value of 1'),
        ];
    }
}
