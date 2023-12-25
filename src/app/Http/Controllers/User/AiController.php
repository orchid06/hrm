<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Http\Requests\ContentRequest;
use App\Http\Services\ContentService;
use App\Models\Admin\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
class AiController extends Controller
{

    use ModelAction ;
    protected $userService ,$user,$contentService;

    public function __construct(){
        
        $this->contentService  = new ContentService();
        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }
    
    /**
     * Content list
     *
     * @return View
     */
    public function list() :View{

        return view('user.content.list',[

            'meta_data'    => $this->metaData(['title'=> translate("Ai Contents")]),

            'contents'     => Content::where('user_id',$this->user->id)
                                ->search(['name'])
                                ->latest()
                                ->paginate(paginateNumber())
                                ->appends(request()->all()),
                                
            'categories'  => Category::template()->doesntHave('parent')->get()

        ]);
    }


    /**
     * Update a specific Article
     *
     * @param ContentRequest $request
     * @return RedirectResponse
     */
    public function update(ContentRequest $request) :RedirectResponse {

        $content = Content::where('user_id',$this->user->id)
                       ->where("id",$request->input('id'))->firstOrfail();
     
        return  back()->with($this->contentService->update($request , $content));
    }



    /**
     * Update a specific Article status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:contents,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"      => new Content(),
            "user_id"    => $this->user->id,
        ]);
    }


    public function destroy(string | int $id) :RedirectResponse{

        $content  = Content::where('user_id',$this->user->id)->where('id',$id)->firstOrfail();
        $content->delete();
        return  back()->with(response_status('Item deleted succesfully'));
    }
    

 
}
