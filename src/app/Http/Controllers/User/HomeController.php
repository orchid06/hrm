<?php

namespace App\Http\Controllers\User;

use App\Enums\FileKey;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;
use App\Models\Attendance;
use App\Models\Admin\Leave;
use App\Models\Admin\Payroll;
use App\Models\Admin\UserDesignation;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\User;
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



    protected $user, $subscription, $accessPlatforms, $webhookAccess, $userService;

    use Fileable;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            $this->userService            = new UserService();
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
        $user = Auth::user();

        $data = [];


        $data['total_attendance'] = Attendance::where('user_id', $user->id)
            ->whereNotNull('clock_in')
            ->count();


        $data['total_late'] = Attendance::where('user_id', $user->id)
            ->whereNull('late_time')
            ->count();


        $data['total_leave'] = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $designation = UserDesignation::where('user_id' , $user->id)
                ->where('status' , StatusEnum::true->status())
                ->first();

        $data['salary'] = @json_decode($designation->salary)->basic_salary->amount;

        $data['total_work_hours'] = round(
            Attendance::where('user_id', $user->id)
                ->sum('work_hour') / 60,
            2
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
        $user           = Auth::user();
        $userDetails    = $this->userService->getUserDetails($user->uid);

        return view('user.profile.index', [
            'breadcrumbs'           => ['Home'=>'user.home' ,'Profile' => null],
            'title'                 => translate('Profile'),
            'user'                  => $userDetails['user'],
            'countries'             => $userDetails['countries'],
            'graph_data'            => $userDetails['graph_data'],
            'card_data'             => $userDetails['card_data']
        ]);
    }

    public function profileEdit(Request $request): View
    {
        $user = Auth::user();

        return view('user.profile.edit' ,[
            'breadcrumbs'   => ['Home'=> 'user.home', 'Profile'=> 'user.profile', 'Profile Edit'=> null],
            'title'         => translate('Edit Employee'),
            'user'          => User::whereUid($user->uid)->first(),
            'departments'   => Department::latest()->get(),
            'designations'  => Designation::latest()->get(),
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
            "image"              => ['nullable', 'image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true))],
            'address'            => ['required', 'string','max:255'],

            'date_of_birth'      => ['required','date', 'before:today'],
            'employee_id'        => ['required', "string" , "max:100"],
            'date_of_joining'    => ['required','date', ],
            'designation_id'     => ['required','exists:designations,id'],

        ]);

        $user                       =  $this->user;
        $user->name                 =  $request->input('name');
        $user->username             =  $request->input('username');
        $user->phone                =  $request->input('phone');
        $user->email                =  $request->input('email');
        $user->address              =  $request->input('address', []);
        $user->country_id           =  $request->input('country_id');

        $user->employee_id          = $request->input('employee_id');
        $user->date_of_birth        = $request->input('date_of_birth');
        $user->date_of_joining      = $request->input('date_of_joining');
        $user->date_of_birth        = $request->input('date_of_birth');

        $user->save();

        UserDesignation::where('user_id', $user->id)->update([
            'designation_id' => $request->input('designation_id')
        ]);


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

            'title'         => translate("Notifications"),
            'notifications' => Notification::where('notificationable_type', 'App\Models\User')
                ->where("notificationable_id", $this->user->id)
                ->latest()
                ->paginate(paginateNumber())
        ]);
    }
}
