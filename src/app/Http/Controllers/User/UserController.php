<?php

namespace App\Http\Controllers\User;

use App\Enums\KYCStatus as EnumsKYCStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycRequest;
use App\Http\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Core\File;
use App\Models\KycLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Models\Admin;
use Carbon\Carbon;
use App\Traits\Notifyable;
use App\Traits\Fileable;
class UserController extends Controller
{

    protected $userService ,$user;

    use Notifyable ,Fileable;
    public function __construct(){

        $this->userService      = new UserService();

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }



    /**
     * Summary of kycForm
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function kycForm() :View  | RedirectResponse {

        if($this->user->is_kyc_verified   == StatusEnum::true->status()) return redirect()->route('user.home');
        return view('user.kyc_form',[

            'title'  => translate('Employee Application Form')
        ]);

    }




    /**
     * Kyc application request
     *
     * @param KycRequest $request
     * @return RedirectResponse
     */
    public function kycApplication(KycRequest $request) :RedirectResponse {

        if($this->user->is_kyc_verified   == StatusEnum::true->status()) return redirect()->route('user.home');

        $pendingKycs = KycLog::where("user_id",$this->user->id)->pending()->count();

        if($pendingKycs > 0) return back()->with(response_status('You already have a pending KYC request, Please wait for our confirmation','error'));

        $kycLog =   DB::transaction(function() use ($request ) {

                        $kycLog                  = new KycLog();
                        $kycLog->user_id         = $this->user->id;
                        $kycLog->status          = EnumsKYCStatus::value("REQUESTED",true);
                        $kycLog->kyc_data        = (Arr::except($request['kyc_data'],['files']));
                        $kycLog->save();

                        if(isset($request["kyc_data"] ['files'])){
                            foreach($request["kyc_data"] ['files'] as $key => $file){
                                $response = $this->storeFile(
                                    file        : $file,
                                    location    : config("settings")['file_path']['kyc']['path'],
                                );
                                if(isset($response['status'])){
                                    $file = new File([
                                        'name'      => Arr::get($response, 'name', '#'),
                                        'disk'      => Arr::get($response, 'disk', 'local'),
                                        'type'      => $key,
                                        'size'      => Arr::get($response, 'size', ''),
                                        'extension' => Arr::get($response, 'extension', ''),
                                    ]);

                                    $kycLog->file()->save($file);
                                }
                            }
                        }

                        $route          =  route("admin.kyc.report.details",$kycLog->id);
                        $admin          = get_superadmin();
                        $code           = [
                            "name"          =>  $this->user->name,
                            "time"          =>  Carbon::now(),
                        ];

                        $notifications = [

                            'database_notifications' => [
                                'action' => [SendNotification::class, 'database_notifications'],
                                'params' => [
                                    [ $admin, 'KYC_APPLIED', $code, $route ],

                                ],
                            ],



                            'email_notifications' => [
                                'action' => [SendMailJob::class, 'dispatch'],
                                'params' => [
                                    [$admin,'KYC_APPLIED',$code],

                                ],
                            ],
                            'sms_notifications' => [
                                'action' => [SendMailJob::class, 'dispatch'],
                                'params' => [[$admin,'KYC_APPLIED',$code]],
                            ],

                        ];

                        $this->notify($notifications);

                        return $kycLog ;
                    });


        return redirect()->route("user.kyc.report.list")->with(response_status('Application submitted! Verification in progress. We will notify you upon completion. Thank you for your patience'));

    }





}
