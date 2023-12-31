<?php

namespace App\Http\Requests;

use App\Http\Services\Account\facebook\Account;
use App\Models\SocialAccount;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Closure;
class SocialPostRequest extends FormRequest
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

            'account_id'    => ['required' ,'array','min:1',function (string $attribute, mixed $value, Closure $fail)  {
                        
                                    $accounts = SocialAccount::whereIn('id',request()->input('account_id',[]))
                                        ->when(request()->routeIs('admin.*'), function ($query) use ($value) {
                                            $query->where('admin_id', auth_user()->id);
                                        })
                                        ->when(request()->routeIs('user.*'), function ($query) use ($value) {
                                                $query->where('user_id', auth_user('web')->id);
                                            })
                                        ->pluck('id')->toArray();

                                    foreach(request()->input('account_id',[]) as $id){
                                        
                                        if(!in_array($id, $accounts)) {
                                            $fail(translate("Recaptcha validation failed"));
                                            break;
                                        }
                                    }
                                            
                            }],
            'account_id.*' => ['required','exists:social_accounts,id'],
    
            'text' => [Rule::requiredIf(function ()  {
                return (!request()->input('link') && !request()->input('files')) ;
            }),'nullable'],
            'link' => [Rule::requiredIf(function ()  {
                            return (!request()->input('text') && !request()->input('files')) ;
                        }),'nullable','url'],
            'files' => [
                    Rule::requiredIf(function ()  {
                        return (!request()->input('text') && !request()->input('link')) ;
                    }),
                'nullable',
                'array',
                'min:1',
                new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true))
            ],
            'files.*' => ['nullable','image'],
            'schedule_date' => ['nullable','date','after:now'],


        ];


        return $rules;
    
    }
}