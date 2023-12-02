<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Http\Services\TicketService;
use App\Http\Utility\SendNotification;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{


    protected $ticketService;

    public function __construct(){
        $this->ticketService = new TicketService();
    }
    
    /**
     * Support Ticket View
     *
     * @return View
     */
    public function list() :View{

        return view('user.ticket.list',[
            'meta_data'=> $this->metaData(["title" => translate("Ticket List")]),
            'tickets' => Ticket::filter()->with(['user','messages'])
            ->where('user_id',auth_user('web')->id)
            ->latest()
            ->paginate(paginateNumber())

        ]);
    }


    /**
     * Support Ticket create
     *
     * @return View
     */
    public function create() :View{

        return view('user.ticket.create',[
            'meta_data'=> $this->metaData(["title" => translate("Create Ticket")]),
        ]);
    }



    /**
     * Create A new Ticket
     *
     * @param TicketRequest $request
     * @return RedirectResponse
     */
    public function store(TicketRequest $request) :RedirectResponse{

        $ticket =  $this->ticketService->store($request->except('_token'));
        return redirect()->route('user.ticket.show',$ticket->ticket_number)->with(response_status('Ticket Successfully Created'));
    }


     /**
     * Support Ticket View
     *
     * @return View
     */
    public function show(string $ticketNumber) :View{

        return view('user.ticket.show',[
            'meta_data'=> $this->metaData(["title" => translate("Ticket Details")]),
            'ticket' => Ticket::with(['user','messages','messages.admin' ,'messages.admin.image'])
            ->where('user_id',auth_user('web')->id)
            ->where("ticket_number",$ticketNumber)
            ->latest()
            ->firstOrFail()
        ]);
    }


    
    /**
     * Reply Ticket
     *
     * @return RedirectResponse
     */
    public function reply(Request $request) :RedirectResponse{

        $request->validate([
            'ticket_id' => "required|exists:tickets,id",
            "message" => 'required'
        ]);

        $ticket = Ticket::where('id',$request->get('ticket_id'))->firstOrFail();
        $message = new Message();
        $message->ticket_id = $request->get('ticket_id');
        $message->message = $request->get("message");
        $message->save();

        if(site_settings('database_notifications') == StatusEnum::true->status()){
            $code = [
                "message" =>   auth_user("web")->name ." Just Replied To a Ticket",
                "url" => route('admin.ticket.show',$ticket->ticket_number)
            ];
            SendNotification::database_notifications($code);
        }


        return back()->with(response_status('Replied Successfully'));
    }


    /**
     * download a file 
     */
    public function download(Request $request) :mixed {

        $request->validate([
            'id'=>'required|exists:images,id',
        ]);

        $url =  $this->ticketService->download($request);
        if(!$url){
            return back()->with('error',translate('File Not Found'));
        }
        return $url;

    }


}
