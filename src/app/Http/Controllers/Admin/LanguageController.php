<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\LanguageRequest;
use App\Http\Services\LanguageService;
use App\Models\Core\Language;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Traits\ModelAction;
class LanguageController extends Controller
{
    use ModelAction;
    public $languageService;

    /**
     * Constructs a new instance of the LanguageService class.
     *
     * @return void
     */

    public function __construct()
    {
        $this->languageService = new LanguageService();

        //check permissions middleware
        $this->middleware(['permissions:view_language'])->only('list');
        $this->middleware(['permissions:create_language'])->only('store');
        $this->middleware(['permissions:update_language'])->only(['setDefaultLang','updateStatus']);
        $this->middleware(['permissions:translate_language'])->only(['translate','tranlateKey']);
        $this->middleware(['permissions:delete_language'])->only(['destroyTranslateKey','destroy']);
    }


    /**
     * Display the language management page.
     *
     * @return \Illuminate\View\View
     */
    public function list() :\Illuminate\View\View
    {

        return view('admin.language.list', [

            'title'         =>  translate("Manage Language"),
            'breadcrumbs'   =>  ['home'=>'admin.home','language'=> null],
            'languages'     =>  Language::with(['updatedBy','createdBy'])
                                        ->search(['name','code'])
                                        ->latest()
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all()),
            'countryCodes'  =>  json_decode(file_get_contents(resource_path(config('constants.options.country_code')) . 'countries.json'),true)
        ]);
    }

    /**
     * Store a new language.
     *
     * @param LanguageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LanguageRequest $request) :\Illuminate\Http\RedirectResponse
    {
        $response = $this->languageService->store($request);
        return back()->with($response['status'],$response['message']);
    }

    /**
     * Make a language as default
     *
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultLang(int | string $id) :\Illuminate\Http\RedirectResponse {

        $response = $this->languageService->setDefault($id);
        return back()->with($response['status'],$response['message']);
    }

    /**
     * Updates the status of a language.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\string
     */
    public function updateStatus(Request $request) :string{

        $response['reload']  = true;
        $response['status']  = false;
        $response['message'] = translate('Failed To Update');

        try {

            $request->validate([
                'id'      => 'required|exists:languages,uid',
                'status'  => ['required',Rule::in(StatusEnum::toArray())],
                'column'  => ['required',Rule::in(['status'])],
            ]);
            $language = Language::where('uid',$request->input('id'))->firstOrfail();
            $response['status']    = true;
            $response['message']   = translate('Updated Successfully');
            if(session()->get('locale') == $language->code || $language->is_default == (StatusEnum::true)->status()){
                $response['status']  = false;
                $response['message'] = translate('System Current and default language Status Can not be Updated');
            }
            else{
                
                $language->status = $request->input('status');
                $language->save();
            }

        } catch (\Throwable $th) {

        }
        return json_encode($response);

    }



    /**
     * Display the language translation page.
     *
     * @param  string $code
     * @return \Illuminate\View\View
     */
    public function translate(string $code) :\Illuminate\View\View{

        return view('admin.language.translate', [
            'title'         =>  translate("Translate language"),
            'breadcrumbs'   =>  ['home'=>'admin.home','language'=> 'admin.language.list' ,"translate"=> null],
            'translations'  =>  $this->languageService->translationVal($code)
        ]);
    }

    /**
     * Translate a specific lang key.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\string
     */
    public function tranlateKey(Request $request) :string{

        $response = $this->languageService->translateLang($request);
        return json_encode([
            "success" => $response
        ]);
    }

    /**
     * Destroy A language
     *
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int | string $id) :\Illuminate\Http\RedirectResponse {
        $response = $this->languageService->destory($id);
        return back()->with( $response['status'],$response['message']);
    }

   

    /**
     * Destroy A language transaltion
     *
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyTranslateKey(int | string $id) :\Illuminate\Http\RedirectResponse {
        $response = $this->languageService->destoryKey($id);
        return back()->with( $response['status'],$response['message']);
    }

    /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new Language(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }
}
