<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\SocialAccount;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialAccountController extends Controller
{
    use ModelAction ;
    protected $ticketService ;

    public function __construct(){

        $this->middleware(['permissions:view_account'])->only(['list']);
        $this->middleware(['permissions:create_account'])->only('list');
        $this->middleware(['permissions:update_account'])->only('destroy');
        $this->middleware(['permissions:delete_account'])->only('destroy');
    }


    /**
     * Social account list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.social.account.list',[

            "title"           => translate("Social Account List"),
            'breadcrumbs'     => ['Home'=>'admin.home','Tickets'=> null],
            'tickets'         => SocialAccount::with(['user','subscription','subscription.package','platform','admin'])
                                  ->filter(["status",'user:username','platform:slug'])
                                  ->latest()
                                  ->paginate(paginateNumber()),
            "platforms"       => get_platform(),
            "packages"        => Package::active()->get(),
        ]);
    }

    


    

    /**
     * Create a new account
     *
     * @return View
     */
    public function create() :View{


        return view('admin.ticket.create',[

            "title"           => translate("Ticket Create"),
            'breadcrumbs'     => ['Home'=>'admin.home','Tickets'=> "admin.ticket.list","Create" => null],


        ]);
    }


    /**
     * store a new ticket
     *
     * @return RedirectResponse
     */
    public function store(TicketRequest $request) :RedirectResponse{

        $response = response_status("Ticket created successfully");
        
        try {
            $ticket =  $this->ticketService->store($request->except('_token') ,$request->input("user_id"));
        } catch (\Exception $ex) {
            $response = response_status(strip_tags($ex->getMessage()),'error');
        }
        return back()->with($response);
    }


    /**
     * Support Ticket View
     *
     * @return View
     */
    public function show(string $ticketNumber) :View{

        return view('admin.ticket.show',[

            "title"        => translate("Ticket Details"),
            'breadcrumbs'  => ['Home'=>'admin.home','Tickets'=> "admin.ticket.list" ,"Reply" => null],
            'ticket'       => Ticket::with(['user',"user.file",'messages','messages.admin' ,'messages.admin.file'])
                                ->where("ticket_number",$ticketNumber)
                                ->latest()
                                ->firstOrFail()
        ]);
    }



    

    /**
     * destroy a ticket
     */
    public function destroy(string $id) :RedirectResponse {

        $ticket   = Ticket::with(['messages','file'])->where('id',$id)->firstOrFail();
        return back()->with($this->ticketService->delete($ticket));

    }


    /**
     * Destroy Message
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroyMessage(string $id) :RedirectResponse {

        $message = Message::where('id',$id)->firstOrFail();
        $message->delete();
        return back()->with(response_status('Message Deleted Successfully'));
    }


    /**
     * Update Ticket Status
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            "id"     => ["required","exists:tickets,id"],
            "key"    => ["required",Rule::in(['priority','status'])],
            'status' => ["required"]
        ]);

        $responseStatus    = response_status('Status Updated');
        $ticket            = Ticket::where('id',$request->input("id"))->firstOrfail();
        $ticket->{$request->input("key")} = $request->input("status");
        $ticket->update();
        return back()->with($responseStatus );
    }



    
}
