<?php

namespace App\Http\Controllers\User;

use App\Enums\FileKey;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\admin\Attendance;
use App\Models\Admin\Leave;
use App\Models\Admin\Payroll;
use Illuminate\Http\Request;

use App\Models\Core\File;
use App\Models\CreditLog;
use App\Models\MediaPlatform;
use App\Models\Notification;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use App\Traits\Fileable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{



    protected $user, $subscription, $accessPlatforms, $webhookAccess;

    use Fileable;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            $this->subscription           = $this->user->runningSubscription;
            $this->accessPlatforms        = (array) ($this->subscription ? @$this->subscription->package->social_access->platform_access : []);
            $this->webhookAccess          = @optional($this->subscription->package->social_access)
                ->webhook_access;

            return $next($request);
        });
    }


    /**
     * User Dashboard
     *
     * @param Request $request
     * @return void
     */
    public function home(Request $request): View
    {

        return view('user.home', [
            'title'     => translate("Dashboard"),
            'data'      => $this->getDashboardData()
        ]);
    }


    /**
     * retrive dashboard data
     */

    public function getDashboardData(): array
    {
        $userId = auth()->user()->id;

        $data = [];


        $data['total_attendance'] = Attendance::where('user_id', $userId)
            ->whereNotNull('clock_in')
            ->count();


        $data['total_absent'] = Attendance::where('user_id', $userId)
            ->whereNull('clock_in')
            ->count();


        $data['total_leave'] = Leave::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();


        $data['salary'] = Payroll::where('user_id', $userId)
            ->first();


        $data['total_work_hours'] = round(
            Attendance::where('user_id', $userId)
                ->sum('work_hour') / 60,2
        );

        return $data;
    }

    /**
     * profile Update view
     *
     * @return View
     */
    public function profile(Request $request): View
    {

        return view('user.profile', [
            'meta_data' => $this->metaData(['title' => translate("Profile")])
        ]);
    }



    /**
     * profile Update
     *
     * @return View
     */
    public function profileUpdate(Request $request): RedirectResponse
    {

        $request->validate([
            'name'               => ["required", "max:100", 'string'],
            'username'           => ['required', "string", "max:155", "alpha_dash", 'unique:users,username,' . $this->user->id],
            "country_id"         => ['nullable', "exists:countries,id"],
            'phone'              => ['unique:users,phone,' . $this->user->id],
            'email'              => ['email', 'required', 'unique:users,email,' . $this->user->id],
            'auto_subscription'  => ['nullable', Rule::in(StatusEnum::toArray())],

            "image"              => ['nullable', 'image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true))]
        ]);

        $user                       =  $this->user;
        $user->name                 =  $request->input('name');
        $user->username             =  $request->input('username');
        $user->phone                =  $request->input('phone');
        $user->email                =  $request->input('email');
        $user->address              =  $request->input('address', []);
        $user->password             =  $request->input('password');
        $user->country_id           =  $request->input('country_id');
        $user->auto_subscription    =  $request->input('auto_subscription') ?? StatusEnum::false->status();

        $user->save();

        if ($request->hasFile('image')) {



            $oldFile = $user->file()->where('type', FileKey::AVATAR->value)->first();
            $this->saveFile(
                $user,
                $this->storeFile(
                    file: $request->file('image'),
                    location: config("settings")['file_path']['profile']['user']['path'],
                    removeFile: @$oldFile
                ),
                FileKey::AVATAR->value
            );
        }


        return back()->with(response_status('Profile Updated'));
    }


    /**
     * update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request): RedirectResponse
    {


        $rules   = [
            'current_password' => 'required|max:100',
            'password'         => 'required|confirmed|min:6',
        ];

        if (site_settings('strong_password') == StatusEnum::true->status()) {

            $rules['password']    =  [
                "required",
                "confirmed",
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ];
        }

        $request->validate($rules);

        $user = $this->user;

        if ($this->user->password && !Hash::check($request->input('current_password'), $this->user->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }

        $user->password = $request->input('password');
        $user->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     *
     */

    public function readNotification(Request $request): string
    {

        $notification = Notification::where('notificationable_type', 'App\Models\User')
            ->where("id", $request->input("id"))
            ->where("notificationable_id", $this->user->id)
            ->first();
        $status  = false;
        $message = translate('Notification Not Found');
        if ($notification) {
            $notification->is_read =  (StatusEnum::true)->status();
            $notification->save();
            $status = true;
            $message = translate('Notification Readed');
        }
        return json_encode([
            "status"  => $status,
            "message" => $message
        ]);
    }


    /**
     * view  all notifications
     *
     */

    public function notification(Request $request): View
    {

        Notification::where('notificationable_type', 'App\Models\User')
            ->where("notificationable_id", $this->user->id)
            ->update([
                "is_read" => (StatusEnum::true)->status()
            ]);

        return view('user.notifications', [
            'meta_data' => $this->metaData(['title' => translate("Notifications")]),
            'notifications' => Notification::where('notificationable_type', 'App\Models\User')
                ->where("notificationable_id", $this->user->id)
                ->latest()
                ->paginate(paginateNumber())
        ]);
    }



    /**
     * Affiliate Config Update
     *
     * @return RedirectResponse
     */
    public function affiliateUpdate(Request $request): RedirectResponse
    {

        $response = response_status('Affiliate System Is Currently Disabled');
        if (site_settings("affiliate_system") == StatusEnum::true->status()) {
            $response = response_status('Referral Code Updated');
            $request->validate([
                'referral_code'      => ['required', 'unique:users,referral_code,' . $this->user->id, 'max:155'],
            ]);

            $user                       =  $this->user;
            $user->referral_code        =  $request->input('referral_code');
            $user->save();
        }

        return back()->with($response);
    }




    /**
     * Webhook Config Update
     *
     * @return RedirectResponse
     */
    public function webhookUpdate(Request $request): RedirectResponse
    {

        $response = response_status('You current plan doesnot have webhook access');
        if ($this->webhookAccess == StatusEnum::true->status()) {
            $response = response_status('Webhook Api Key Updated');
            $request->validate([
                'webhook_api_key'      => ['required', 'unique:users,webhook_api_key,' . $this->user->id],
            ]);

            $user                       =  $this->user;
            $user->webhook_api_key      =  $request->input('webhook_api_key');
            $user->save();
        }

        return back()->with($response);
    }
}
