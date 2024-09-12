<?php

namespace App\Http\Services;

use App\Enums\BalanceTransferType;
use App\Enums\DepositStatus;
use App\Enums\FileKey;
use App\Enums\PlanDuration;
use App\Enums\StatusEnum;
use App\Enums\SubscriptionStatus;
use App\Enums\WithdrawStatus;
use App\Http\Requests\Admin\BalanceUpdateRequest;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Payroll;
use App\Models\Admin\Withdraw;
use App\Models\AffiliateLog;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Core\File;
use App\Models\Country;
use App\Models\CreditLog;
use App\Models\KycLog;
use App\Models\Package;
use App\Models\PaymentLog;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use App\Traits\Notifyable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class UserService
{


    use Fileable, ModelAction, Notifyable;
    protected PaymentService $paymentService;
    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }



    /**
     * Get user list view informations
     *
     * @return array
     */
    public function getList(): array
    {

        return [

            'breadcrumbs'  =>  ['Home' => 'admin.home', 'Employee' => null],
            'title'        => 'Manage Employees',

            'users'        =>  User::with([
                'file',
                'createdBy',
                'country',
            ])
                ->routefilter()
                ->search(['name', 'email', "phone"])
                ->filter(['country:name'])
                ->latest()
                ->paginate(paginateNumber())
                ->appends(request()->all()),

            "countries"    => get_countries(),

        ];
    }



    /**
     * Save a specific user
     *
     * @param Request $request
     * @return User
     */
    public function save(Request $request): User
    {

        return  DB::transaction(function () use ($request): User | null {



            $user                       =  User::with('file')->firstOrNew(['id' => $request->input("id")]);
            $user->name                 =  $request->input('name');
            $user->username             =  $request->input('username');
            $user->phone                =  $request->input('phone');
            $user->email                =  $request->input('email');
            $user->country_id           =  $request->input('country_id');
            $user->status               = $request->input('status');
            $user->password             =  $request->input('password');
            $user->address              =  $request->input('address', []);
            $user->date_of_birth        = $request->input('date_of_birth');
            $user->email_verified_at    =  $request->input('email_verified') ? Carbon::now() : null;


            $user->employee_id          = $request->input('employee_id');
            $user->date_of_joining      = $request->input('date_of_joining');

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
            return $user;
        });
    }




    /**
     * Get user report & statistics
     *
     * @return array
     */
    public function getReport(): array
    {

        $currentYear   = date("Y");
        $currentMonth  = request()->input('month', date("m"));



        $usersByCountries    =   User::with(['country'])
            ->select(DB::raw("count(id) as total, country_id"))
            ->groupBy('country_id')
            ->orderBy('total')
            ->lazyById(paginateNumber(), 'country_id')->mapWithKeys(
                fn(User $user) =>
                [$user->country->name => $user->total]
            )->toJson();

        $topCountries        =   Country::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(30)
            ->get();


        $currentYearUsers    =  sortByMonth(User::selectRaw("MONTHNAME(created_at) as months,  count(*) as total")
            ->whereYear('created_at', '=', date("Y"))
            ->groupBy('months')
            ->pluck('total', 'months')
            ->toArray());


        $daysInMonth      = Carbon::createFromDate($currentYear, $currentMonth, 1)->daysInMonth;
        $days             = array_fill(1, $daysInMonth, 0);
        $currentMonthData = DB::table('users')
            ->selectRaw("DAY(created_at) as day, count(*) as total")
            ->whereYear('created_at', '=', $currentYear)
            ->whereMonth('created_at', '=', $currentMonth)
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $currentMonthUsers = array_replace($days, $currentMonthData);

        return [

            'title'                    =>  'User statistics',
            'user_by_countries'        =>  $usersByCountries,
            'top_countries'            =>  $topCountries,
            'subscribed_users'         =>  User::whereHas('subscriptions')->count(),
            'unsubscribed_users'       =>  User::whereDoesntHave('subscriptions')->count(),
            'active_users'             =>  User::active()->count(),
            'banned_users'             =>  User::banned()->count(),
            'user_by_year'             =>  $currentYearUsers,
            'user_by_month'            =>  $currentMonthUsers,
        ];
    }






    /**
     * Get a specific user details
     *
     * @param string $uid
     * @return array
     */
    public function getUserDetails(string $uid): array
    {
        $currentMonth = Carbon::now()->format('F');



        $user  = User::with([
            'file',
            'kycLogs',
            'transactions',
            'tickets',
            'userDesignation',
            'attendances'
        ])->where('uid', $uid)
            ->firstOrFail();


        $graphData = new Collection();

        Attendance::whereYear('date', date('Y'))
                            ->where('user_id', $user->id)
                            ->selectRaw("
                        MONTH(date) as month,
                        MONTHNAME(date) as months,
                        COUNT(CASE WHEN clock_in IS NOT NULL THEN 1 END) AS attendance,
                        SUM(CASE WHEN late_time > 0 THEN 1 END) AS late,
                        SUM(work_hour) AS total_work_minutes
                    ")
            ->groupBy('month', 'months')
            ->orderBy('month')
            ->chunk(100, function (Collection $logs) use (&$graphData): void {
                $graphData = $logs->map(
                    fn($log): array =>
                    [
                        $log->months => [
                            'attendance' => $log->attendance ?? 0,
                            'late' => $log->late ?? 0,
                            'work_hour' => intdiv($log->total_work_minutes ?? 0, 60)
                        ]
                    ]
                );
            });

            $currentMonthData = $graphData->firstWhere(function ($item) use ($currentMonth) {
                return array_key_exists($currentMonth, $item);
            });

            $totalSalary = Payroll::where('user_id', $user->id)
                        ->sum('net_pay');

            $cardData = [
                'total_attendance'      => $currentMonthData[$currentMonth]['attendance'] ?? 0,
                'total_late'            => $currentMonthData[$currentMonth]['late'] ?? 0,
                'total_work_minutes'    => $currentMonthData[$currentMonth]['work_hour'] ?? 0,
                'total_work_hours'      => $currentMonthData[$currentMonth]['work_hour'] ?? 0,
                'total_salary_received' => $totalSalary
            ];

        return [

            'user'                 => $user,
            "countries"            => get_countries(),
            "card_data"            => $cardData,
            "graph_data"           => sortByMonth(
                @$graphData->collapse()->all() ?? [],
                true,
                [
                    'attendance'        => 0,
                    'work_hour'         => 0,
                    'late'              => 0,
                ]
            )

        ];
    }




    /**
     * Delete a specific users
     *
     * @param integer|string $uid
     * @return array
     */
    public function delete(int|string $uid): array
    {

        try {
            DB::transaction(function () use ($uid): void {

                $user      = User::with(
                    [
                        'file',
                        "otp",
                        'notifications',
                        'tickets',
                        'tickets.messages',
                        'tickets.file',
                        'templates',
                        'templateUsages',
                        'kycLogs',
                        'kycLogs.file',
                        'bank_accounts',
                        'designations',
                        'userDesignation',
                        'payrolls',
                        'payslip',
                        'attendances'
                    ]
                )->where('uid', $uid)
                    ->firstOrfail();


                #DELETE OTP
                $user->otp()->delete();

                #DELETE NOTIFICATIONS
                $user->notifications()->delete();

                #DELETE BANK_ACCOUNTS
                $user->bank_accounts()->delete();

                #DELETE DESIGNATIONS
                $user->designations()->delete();

                #DELETE USER_DESIGNATIONS
                $user->userDesignation()->delete();

                #DELETE PAYROLLS
                $user->payrolls()->delete();

                #DELETE PAYSLIP
                $user->payslip()->delete();

                #DELETE ATTENDENCES
                $user->attendances()->delete();


                #DELERE TEMPLATE REPORTS
                $user->templates()->delete();

                #DELETE TEMPLATE REPORT
                $user->templateUsages()->delete();

                #DELETE TICKET LOGS
                $user->tickets?->map(function (Ticket $ticket): bool {
                    $ticket->messages()->delete();
                    return $this->unlinkLogFile($ticket, config("settings")['file_path']['ticket']['path']);
                });
                $user->tickets()->delete();


                #DELETE KYC LOGS
                $user->kycLogs?->map(fn(KycLog $kycLog): bool => $this->unlinkLogFile($kycLog, config("settings")['file_path']['kyc']['path']));
                $user->kycLogs()->delete();


                #UNLINK USER IMAGE
                $this->unlink(
                    location: config("settings")['file_path']['profile']['user']['path'],
                    file: $user->file()->where('type', FileKey::AVATAR->value)->first()
                );

                $user->delete();
            });
        } catch (\Exception $ex) {

            return ['status' => false, 'message' => strip_tags($ex->getMessage())];
        }

        return ['status' => true, 'message' => translate("Deleted Successfully")];
    }


    /**
     * Unlink log files
     *
     * @param mixed $log
     * @param string $path
     * @return bool
     */
    public function unlinkLogFile(Model $model, string $path): bool
    {

        try {
            $model->file->map(fn(File $file): bool =>  $this->unlink(
                location: $path,
                file: $file
            ));

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    /**
     *Save custom field
     *
     * @param Request $request
     * @param mixed $log
     * @param object $params
     * @param string $key
     * @return void
     */
    public function saveCustomInfo(Request $request, mixed $log, object $params, string $key, string $fileLocation): void
    {


        $collection    = collect($request);
        $customData    = [];
        if ($params != null) {

            foreach ($collection as $k => $v) {

                foreach ($params as $inKey => $inVal) {

                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {

                                try {

                                    $response = $this->storeFile(
                                        file: $request->file($inKey),
                                        location: config("settings")['file_path'][$fileLocation]['path'],
                                    );

                                    if (isset($response['status'])) {

                                        $file = new File([

                                            'name'      => Arr::get($response, 'name', '#'),
                                            'disk'      => Arr::get($response, 'disk', 'local'),
                                            'type'      => $inKey,
                                            'size'      => Arr::get($response, 'size', ''),
                                            'extension' => Arr::get($response, 'extension', ''),
                                        ]);

                                        $log->file()->save($file);
                                    }

                                    $customData[$inKey] = [

                                        'field_name' => Arr::get($response, 'name', "#"),
                                        'type'       => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                }
                            }
                        } else {
                            $customData[$inKey] = $v;
                            $customData[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }

            $log->{$key} = $customData;
            $log->save();
        }
    }



    /**
     * manual  input validation rules
     *
     * @param mixed $params
     * @return array
     */
    public function paramValidationRules(mixed $params): array
    {

        $rules           = [];
        $verifyImages    = [];
        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];

                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true)));
                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
            }
        }

        return $rules;
    }
}
