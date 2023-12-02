<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AiTemplateRequest extends FormRequest
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
        $rules = [
            'name'             => ["required","unique:ai_templates,name,".request()->id],
            'slug'             => ['unique:ai_templates,slug,'.request()->id],
            'category_id'      => ["required","exists:categories,id"],
            'description'      => ["required",'max:200',"string"],
            'icon'             => ["required",'max:100'],
            'is_default'       => ["required", Rule::in(StatusEnum::toArray())],
            'custom_prompt'    => ["required","string"],
            "field_name"       => ["nullable",'array'],
            "field_name.*"     => ["nullable","max:255"],
            "type"             => ["nullable",'array'],
            "type.*"           => ["nullable", Rule::in(['text','file','textarea',"password"])],
            "validation"       => ["nullable",'array', Rule::in(['required','nullable'])],
            "validation.*"     => ["nullable"],
        ];
        if(request()->routeIs('admin.ai.template.update')){
            $rules['id'] = ["required",'exists:ai_templates,id'];
        }
        return $rules;
    }
}
