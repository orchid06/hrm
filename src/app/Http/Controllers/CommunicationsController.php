<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\Admin\ClientRequest;
use App\Http\Requests\ContactRequest;

use App\Http\Utility\SendNotification;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Core\File;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
class CommunicationsController extends Controller
{
   /**
     * contact view
     *
     * @return View
     */
    public function contact() :View{
        return view('frontend.contacts',[
            'meta_data'=> $this->metaData([],'contacts'),
            'breadcrumbs' =>  ["title" => "Contact",'Home' =>'home',"Contact"=>null],
        ]);
    }


    /**
     * contact store
     *
     * @return View
     */
    public function store(ContactRequest $request) :RedirectResponse{

        $contact = new Contact();
        $contact->name = $request->get("name");
        $contact->email = $request->get("email");
        $contact->address = $request->get("address");
        $contact->message = $request->get("message");
        $contact->save();

        if(site_settings('database_notifications') == StatusEnum::true->status()){
            $code = [
                "message" => $contact->name." Just contacted you.",
                "url" => route('admin.contact.list')
            ];
            SendNotification::database_notifications($code);
        }

        return  back()->with(response_status('Contacted Successfully'));
    }



    /**
     * Subscribes
     *
     * @return View
     */
    public function subscribe(Request $request) :RedirectResponse{

        $request->validate([
            'email' =>'required|email|unique:subscribers,email'
        ],[
            "email.unique" => translate("Already Subscribed !!")
        ]);
        
        $subscriber = new Subscriber();
        $subscriber->email = $request->get("email");
        $subscriber->save();

        if(site_settings('database_notifications') == StatusEnum::true->status()){
            $code = [
                "message" => $subscriber->email." Just Subscribed",
                "url" => route('admin.subscriber.list')
            ];
            SendNotification::database_notifications($code);
        }

        return  back()->with(response_status('Subscribed Successfully'));
    }


    /**
     * Feedback view
     *
     * @return View
     */
    public function feedback() :View{
        return view('frontend.feedback',[
            'meta_data'=> $this->metaData([],'feedback'),
            'breadcrumbs' =>  ["title" => "Feedback",'Home' =>'home',"Feedback"=>null],
        ]);
    }


    /**
     * Feedback Store
     *
     * @return RedirectResponse
     */
    public function feedbackStore(ClientRequest $request) :RedirectResponse{

      

        return  back()->with(response_status('Thank you for your feedback! It is under review.'));
  
    }


}
