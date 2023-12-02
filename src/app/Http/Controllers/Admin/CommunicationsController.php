<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utility\SendMail;
use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Http\Services\ContactService;
use App\Http\Services\SubscriberService;

class CommunicationsController extends Controller
{
    private $contactService, $subscriberService;
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->contactService = new ContactService();
        $this->subscriberService = new SubscriberService();
        $this->middleware(['permissions:view_frontend'])->only('subscriber','contact');
        $this->middleware(['permissions:update_frontend'])->only(['destroySubscriber','destroy']);
    }


    /**
     * subscriber list
     *
     * @return View
     */
    public function subscriber() :View{

        return view('admin.communication.subscriber',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Subscribers'=> null],
            'title' => 'Manage Subscribers',
            'subscribers' => request()->routeIs('admin.subscriber.list') ?
            Subscriber::filter()->latest()->paginate(paginateNumber())->appends(request()->all()):
            Subscriber::onlyTrashed()->filter()->latest()->paginate(paginateNumber())->appends(request()->all())
        ]);
    }

    /**
     * contact list
     *
     * @return View
     */
    public function contact() :View{

        return view('admin.communication.contact',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Contacts'=> null],
            'title' => 'Manage Contacts',
            'contacts' => request()->routeIs('admin.contact.list') ?
                Contact::filter()->latest()->paginate(paginateNumber())->appends(request()->all()):
                Contact::onlyTrashed()->filter()->latest()->paginate(paginateNumber())->appends(request()->all())
        ]);
    }


    /**
     * destroy a specific contact
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroy(string $uid) :RedirectResponse{

        $contact  = Contact::where('uid',$uid)->firstOrFail();
        $response =  response_status('Contact Not Found','error');
        if($contact){
            $contact->delete();
            $response =  response_status('Contact Deleted');
        }
        return  back()->with($response);
    }
    public function forceDestroy($id) :RedirectResponse{

        $response = response_status('Contact Not Found', 'error');
        $contact = Contact::onlyTrashed()->where('id', $id)->firstOrFail();
        if($contact->trashed()){
            $response =  response_status('Contact Deleted');
            $contact->forceDelete();
        }
        return back()->with($response);
    }

    public function restore($id) :RedirectResponse{
        $contact = Contact::onlyTrashed()->where('id', $id)->firstOrFail();
        $contact->restore();
        $response =  response_status('Contact Restored');
        return redirect()->route('admin.archive')->with($response);
    }

    /**
     * destroy a specific subscriber
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroySubscriber(string $uid) :RedirectResponse{

        $subscriber  = Subscriber::where('uid',$uid)->firstOrfail();
        $response =  response_status('Subscriber Not Found','error');
        if($subscriber){

            $subscriber->delete();
            $response =  response_status('Subscriber Deleted');
        }
        return  back()->with($response);
    }
    public function forceDestroySubscriber($id) :RedirectResponse{

        $response = response_status('Subscriber Not Found', 'error');
        $subscriber = Subscriber::onlyTrashed()->where('id', $id)->firstOrFail();
        if($subscriber->trashed()){
            $response =  response_status('Subscriber Deleted');
            $subscriber->forceDelete();
        }
        return back()->with($response);
    }

    public function restoreSubscriber($id) :RedirectResponse{
        $subscriber = Subscriber::onlyTrashed()->where('id', $id)->firstOrFail();
        $subscriber->restore();
        $response =  response_status('Subscriber Restored');
        return redirect()->route('admin.subscriber.archive')->with($response);
    }


    /**
     * send mail
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendMail(Request $request) :RedirectResponse{

        $request->validate([
            'message'=>'required',
            'email'=>'email|required',
        ],[
            'message.required' => translate('Message Is Required'),
            'email.required' => translate('Email Required'),
        ]);

        $templateCode =[
            'name' =>  $request->email,
            'email' => $request->email,
            "message" => $request->message
        ];

        $response = SendMail::mailNotifications('CONTACT_REPLY',$templateCode ,(object) $templateCode);

        return back()->with(response_status(Arr::get($response,'message',""),$response['status'] ? "success" :"error"));
    }

     /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulkContact(Request $request) :RedirectResponse {

        $bulkIds = json_decode($request->input('bulk_id'), true);
        $request->merge([
            "bulk_id" =>  $bulkIds
        ]);

        $rules = [
            'bulk_id' => ['array', 'required'],
            'bulk_id.*' => ['exists:contacts,id'],
            'type' => ['required', Rule::in(['delete', 'restore'])],
        ];
        $request->validate($rules);
        $response = $this->contactService->bulktAction( $request);
        return  back()->with($response);
    }

    public function bulkSubscriber(Request $request) :RedirectResponse {

        $bulkIds = json_decode($request->input('bulk_id'), true);
        $request->merge([
            "bulk_id" =>  $bulkIds
        ]);

        $rules = [
            'bulk_id' => ['array', 'required'],
            'bulk_id.*' => ['exists:subscribers,id'],
            'type' => ['required', Rule::in(['delete', 'restore'])],
        ];
        $request->validate($rules);
        $response = $this->subscriberService->bulktAction( $request);
        return  back()->with($response);
    }

}
