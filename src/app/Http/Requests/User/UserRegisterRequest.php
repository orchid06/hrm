<?php

namespace App\Http\Requests\User;

use App\Enums\StatusEnum;
use App\Http\Services\User\AuthService;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $googleCaptcha = (object) json_decode(site_settings("google_recaptcha"));
        $rules =  $this->get_validation(request()->except(['_token']))['rules'];
        if(site_settings("captcha_with_registration") == StatusEnum::true->status()){

            if(site_settings("default_recaptcha") == StatusEnum::true->status()){
                $rules['default_captcha_code'] = (new AuthService())->captchaValidationRules();                
            }
            elseif($googleCaptcha->status == StatusEnum::true->status()){
                $rules['g-recaptcha-response'] = (new AuthService())->captchaValidationRules("google");      
            }

        }
       
        return  $rules;
    }


    /**
     * get validation message
     *
     * @return array
     */
    public function messages() :array
    {
        $validation  =  $this->get_validation(request()->except(['_token']));
        return $validation ['message'];
    }

    /**
     * get validation rules and mes
     *
     * @param array $request_data
     * @return array
     */
    public function get_validation(array $request_data) :array{

        $rules = [];
        $message = [];
        $inputFeilds = json_decode(site_settings('user_registration_settings'),true);
        foreach( $inputFeilds as $fields){
            if($fields['required'] == StatusEnum::true->status()){
                if($fields['type'] == 'file'){
                    $rules['register_data.'.$fields['name'].".*"] = ['required', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true),'Ticket File')];
                }
                
                if($fields['type'] == 'email'){
              
                    $rules['register_data.'.$fields['name']] = ['required','email','unique:users,email'];
                    $message['register_data.'.$fields['name'].".email"] = ucfirst($fields['name']).translate(' Feild Is Must Be Contain a Valid Email');
                }

                elseif($fields['type'] == 'password' && $fields['name'] ==  'password'){
                    $rules['register_data.'.$fields['name']] = ['required', 'confirmed', 'min:5'];
                }
                elseif( $fields['name'] ==  'phone' || $fields['name'] ==  'user_name' ){
                    
                    $rules['register_data.'.$fields['name']] = ['required', 'unique:users,'.$fields['name']];
                }
                else{
                    if($fields['status'] ==  StatusEnum::true->status()){
                        $rules['register_data.'.$fields['name']] = ['required'];
                    }
                    
                }
             
            }
        }

        return  [
            'rules' => $rules,
            'message' => $message,
        ];
    }
}
