<?php
namespace App\Http\Services;

use App\Enums\PlanDuration;
use App\Models\AiTemplate;
use App\Models\TemplateUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Traits\ModelAction;
use Illuminate\Validation\Rule;
use Orhanerday\OpenAi\OpenAi;

class AiService
{

    use  ModelAction;



    /**
     * store template
     *
     * @param Request $request
     * @return void
     */
    public function saveTemplate(Request $request) :array{

        $response = response_status('Template created successfully');
        try {
            $template                  = new AiTemplate();
            $template->name            = $request->input("name");
            $template->category_id     = $request->input("category_id");
            $template->description     = $request->input("description");
            $template->icon            = $request->input("icon");
            $template->custom_prompt   = $request->input("custom_prompt");
            $template->is_default      = $request->input("is_default");
            $template->save();
            
        } catch (\Exception $ex) {
            $response = response_status(strip_tags($ex->getMessage()),'error');
        }

        return  $response;
      
    }


    /**
     * update template
     *
     * @param Request $request
     * @return void
     */
    public function updateTemplate(Request $request) :array{

      
        
        $response = response_status('Template updated successfully');

        try {
            $template                  = AiTemplate::findOrfail($request->input('id'));
            $template->name            = $request->input("name");
            $template->category_id     = $request->input("category_id");
            $template->description     = $request->input("description");
            $template->icon            = $request->input("icon");
            $template->custom_prompt   = $request->input("custom_prompt");
            $template->is_default      = $request->input("is_default") ?? $request->input("is_default");
            $template->prompt_fields   = $this->parseManualParameters();
            $template->save();
            
        } catch (\Exception $ex) {
            $response = response_status($ex->getMessage(),'error');
        }

        return  $response;
    }


    public function setRules(Request $request) :array{

        $rules = [
            "language"         => ['required',"exists:languages,name"],
            "id"               => ['required',"exists:ai_templates,id"],
            "max_result"       => ['nullable',"numeric",'gt:0','max:5000'],
            "ai_creativity"    => ['nullable',Rule::in(array_values(Arr::get(config('settings'),'default_creativity',[])))],
            "content_tone"     => ['nullable',Rule::in(Arr::get(config('settings'),'ai_default_tone',[]))],
            "custom"           => ['nullable','array']
        ];
        $template = AiTemplate::findOrfail($request->input('id'));

        if($template->prompt_fields){

            foreach($template->prompt_fields as $key => $input){
                if($input->validation == "required"){
                    $rules['custom.'.$key]   = ['required'];
                }
            }
        }
       
        return [
            'template' => $template,
            'rules'    =>  $rules ,
        ];

    }

    public function generatreContent(Request $request ,AiTemplate $template) :array{


        $logData ['template_id'] = $template->id;

        $logData['admin_id']     = request()->routeIs('admin.*') ? auth_user('admin')?->id : null;
        $logData['user_id']      = request()->routeIs('user.*') ? auth_user('web')?->id : null;
   
        $customPrompt = $template->custom_prompt;

        if($request->input("custom") &&  $template->prompt_fields){
            foreach($template->prompt_fields as $key => $input){
                $customPrompt = str_replace("{".$key."}",Arr::get($request->input("custom"),$key,"",),$customPrompt);
            }
        }
        $getBadWords     = site_settings('ai_bad_words');
        $processBadWords = $getBadWords ? explode(",",$getBadWords) :[];
        
        if(is_array($processBadWords)){
            $customPrompt = str_replace($processBadWords,"",$customPrompt);
        }

         $model          =  site_settings("open_ai_model");
         
         $temperature    = (float)  ($request->input("ai_creativity") ?  $request->input("ai_creativity") : site_settings("ai_default_creativity"));
         $aiParams = [
            'model'             => $model,
            'temperature'       => $temperature, 
            'presence_penalty'  => 0.6,
            'frequency_penalty' => 0,
        ];

        $aiTone = $request->input("content_tone") ?  $request->input("content_tone") : site_settings("ai_default_tone");

        $tokens = (int) ($request->input("max_result") ?  $request->input("max_result") : site_settings("default_max_result",-1));

        $customPrompt .= 'Write in ' . $request->input("language") . ' language.'  . ' The tone of voice should be ' . $aiTone . ' Do not write translations.';  

        if ($tokens != PlanDuration::UNLIMITED->value) {
            $aiParams['max_tokens'] = $tokens;
            $customPrompt .= 'Write in ' . $request->input("language") . ' language.'  . ' The tone of voice should be ' . $aiTone . ' and the output must be completed in ' . $tokens . ' words. Do not write translations.';
        } 
       
    
        $aiParams['messages'] = [[
            "role"     => "user",
            "content"  => $customPrompt
        ]];
        
        return  $this->generateContent($aiParams,$logData);

    }


    public function generateContent(array $aiParams , array $logData) :array {

        $status       = false;
        $message      = translate("Invalid Request");
        $open_ai      = new OpenAi(openai_key());
        $chat_results = json_decode($open_ai->chat($aiParams),true);
        if(isset($chat_results['error'])){
            $message        = Arr::get($chat_results['error'],'message',translate('Invalid Request'));
        }
        else{

            if(isset($chat_results['choices'][0]['message']['content'])){

                $realContent                   = $chat_results['choices'][0]['message']['content'];
                $content                       = str_replace(["\r\n", "\r", "\n"] ,"<br>",$realContent); 
                $usage                         = $chat_results['usage'];
                $usage['model']                = $chat_results['model'];
                $usage['genarated_tokens']     = count(explode(' ', ($content)));

                $templateLog                   = new TemplateUsage();
                $templateLog->user_id          = Arr::get($logData,'user_id',null);
                $templateLog->admin_id         = Arr::get($logData,'admin_id',null);
                $templateLog->template_id      = Arr::get($logData,'template_id',null);
                $templateLog->package_id       = Arr::get($logData,'package_id',null);
                $templateLog->open_ai_usage    = $usage;
                $templateLog->content          = $content;
                $templateLog->total_words      = Arr::get($usage,'genarated_tokens',0);
                $templateLog->save();

                #todo : generate subscription credit log and deduct word credit if user exists

                $status         = true;
                $message        = $realContent;
            }
            
        
        }

        return [
            "status"      => $status,
            "message"     => $message,
        ];
      
    }


}
