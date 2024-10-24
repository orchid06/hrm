<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\Admin\PayrollService;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Services\UserService;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;
use App\Models\Admin\UserDesignation;
use App\Traits\ModelAction;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    use ModelAction;


    public function __construct(protected UserService $userService, protected PayrollService $payrollService)
    {
        $this->middleware(['permissions:view_user'])->only('list', 'show', 'selectSearch');
        $this->middleware(['permissions:create_user'])->only(['store', 'create']);
        $this->middleware(['permissions:update_user'])->only(['updateStatus', 'update', 'login', 'balance']);
        $this->middleware(['permissions:delete_user'])->only(['destroy']);
    }



    /**
     * Get user list
     *
     * @return View
     */
    public function list(Request $request): View
    {

        return view('admin.user.list', $this->userService->getList());
    }



    /**
     * Get user statistics
     *
     * @return View
     */
    public function statistics(): View
    {
        return view('admin.user.statistics', $this->userService->getReport());
    }


    public function create(): View
    {
        $title         =  translate('Create Employee');
        $breadcrumbs   =  ['Home' => 'admin.home', 'Employees' => 'admin.user.list', 'Create Employee' => null];
        return view('admin.user.create', [

            'breadcrumbs'   =>  $breadcrumbs,
            'title'         =>  $title,
            'departments'   =>  Department::latest()->get(),
            'designations'  =>  Designation::latest()->get()
        ]);
    }

    /**
     * Store a  new user
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        
        $user = $this->userService->save($request);

        UserDesignation::create([
            'user_id'        => $user->id,
            'designation_id' => $request->input('designation_id'),
            'basic_salary'   => $request->input('basic_salary')
        ]);

        return  back()->with(response_status('User created successfully'));
    }


    /**
     * Show specific user
     *
     * @param string $uid
     * @return View
     */
    public function show(string $uid): View
    {

        $userDetails = $this->userService->getUserDetails($uid);

        $months        = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [
                Carbon::createFromDate(null, $month, 1)->format('Y-m') => Carbon::createFromDate(null, $month, 1)->format('F')
            ];
        });

        return view('admin.user.show', [
            'breadcrumbs'           => ['Home' => 'admin.home', 'Employee list' => 'admin.user.list', 'Profile' => null],
            'title'                 => translate('Employee Profile'),
            'user'                  => $userDetails['user'],
            'countries'             => $userDetails['countries'],
            'graph_data'            => $userDetails['graph_data'],
            'card_data'             => $userDetails['card_data'],
            'attendance_graph_data' => $userDetails['attendance_graph_data'],
            'months'                => $months
        ]);
    }

    public function edit(string $uid): View
    {

        return view('admin.user.edit', [
            'breadcrumbs'   => ['Home' => 'admin.home', 'Employees' => 'admin.user.list', 'Employee Edit' => null],
            'title'         => translate('Edit Employee'),
            'user'          => User::whereUid($uid)->first(),
            'departments'   => Department::latest()->get(),
            'designations'  => Designation::latest()->get(),
        ]);
    }


    /**
     * Update a specific user
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function update(UserRequest $request): RedirectResponse
    {
        $user = $this->userService->save($request);

        UserDesignation::updateOrCreate(
            ['user_id' => $user->id],
            ['designation_id' => $request->input('designation_id')]
        );

        return  back()->with(response_status('User updated successfully'));
    }



    /**
     * Update a specific user status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request): string
    {

        $request->validate([
            'id'      => 'required|exists:users,uid',
            'status'  => ['required', Rule::in(StatusEnum::toArray())],
            'column'  => ['required', Rule::in(['status'])]
        ]);
        return $this->changeStatus($request->except("_token"), ["model"    => new User()]);
    }


    /**
     * Destroy a specific user
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroy(int | string $uid): RedirectResponse
    {
        $response = $this->userService->delete($uid);
        return  back()->with(Arr::get($response, 'status') ? 'success' : 'error', Arr::get($response, 'message'));
    }




    /**
     * login in as a user
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function login(string $uid): RedirectResponse
    {

        $user                        = User::where('uid', $uid)->firstOrfail();
        $user->email_verified_at     = Carbon::now();
        $user->last_login            = Carbon::now();
        $user->save();
        Auth::guard('web')->loginUsingId($user->id);
        return redirect()->route('user.home')
            ->with(response_status('Successfully logged In As a User'));
    }


    /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulk(Request $request): RedirectResponse
    {
        $request->validate([
            'bulk_id' => 'required|string',
            'type' => 'required|string',
        ]);

        if ($request->input('type') === 'pay') {

            $userIds    = json_decode($request->input('bulk_id'), true);
            $month      = now()->format('Y-m');

            $results = $this->payrollService->createPayrolls($userIds, $month);

            if (!empty($results['errors'])) {
                return back()->with('error', implode(', ', $results['errors']));
            }

            return back()->with('success', trans('Payslip generated successfully'));
        }



        try {
            $response =  $this->bulkAction($request, ["model" => new User()]);
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(), 'error');
        }
        return  back()->with($response);
    }

    public function getCustomOfficeHour($userId): JsonResponse
    {

        $user = User::find($userId);

        $customOfficeHour = $user->custom_office_hour ? json_decode($user->custom_office_hour, true): [];

        $html = view('admin.user.custom_office_hour', ['custom_office_hour' => $customOfficeHour])->render();


        return response()->json([
            'html' => $html
        ]);
    }

    public function storeCustomOfficeHour(Request $request)
    {
        $days =  [
            'Monday'    =>  'Monday',
            'Tuesday'   =>  'Tuesday',
            'Wednesday' =>  'Wednesday',
            'Thursday'  =>  'Thursday',
            'Friday'    =>  'Friday',
            'Saturday'  =>  'Saturday',
            'Sunday'    =>  'Sunday',
        ];

        $request->validate([

            'operating_day'   => ['nullable', 'array'],
            'operating_day.*' => ['nullable', Rule::in(array_keys($days))],
            'start_time'      => ['required', 'array'],
            'end_time'        => ['required', 'array'],

        ], [
            'end_time.*.required'   => translate('Please select end time'),
            'start_time.*.required' => translate('Please select start time'),
        ]);


        $customOfficeHour = collect($days)->map(function (string $day, string $key) use ($request) {

            return
            [t2k($key)=>[

                'is_on'     =>  in_array($key, $request->input('operating_day', [])),
                'clock_in' =>  Arr::get($request->input('start_time', []), $key),
                'clock_out'   =>  Arr::get($request->input('end_time', []), $key),
            ]];

        })->collapse()->all();

        User::find($request->input('user_id'))->update([
            'custom_office_hour' => $customOfficeHour
        ]);



        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Office Hour has been updated')
        ]);
    }
}
