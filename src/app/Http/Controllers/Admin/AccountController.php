<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Models\Admin\Account;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;
use App\Models\Core\File;
use Illuminate\Support\Arr;

class AccountController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_account'])->only(['list']);
        $this->middleware(['permissions:create_account'])->only(['store','create']);
        $this->middleware(['permissions:update_account'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_account'])->only(['destroy','bulk']);
    }


    public function list()
    {
        return view('admin.account.index',[

            'title'                 =>  translate('Manage Accounts'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Accounts'=> null],
            'accounts'              => Account::latest()
                                        ->search(['name'])
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all())
        ]);
    }

    public function create()
    {
        return view('admin.account.create',[

            'title'                 =>  translate('create Accounts'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Accounts'=> 'admin.account.list' , 'Create Account' => null],

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:191',
            'balance'               => 'numeric|min:0',
            'custom_inputs'         => 'required|array',
            'custom_inputs.*.key'   => 'string|max:255',
            'custom_inputs.*.value' => 'string|max:255',
            'custom_inputs.*.file'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $customInputs = $request->input('custom_inputs');

        $account = Account::create([
            'name'          => $request->input('name'),
            'balance'       => $request->input('balance'),
            'custom_inputs' => json_encode($customInputs),
        ]);



        foreach($customInputs as $customInput){

            if (isset($customInput['file'])) {

                $file = $customInput['file'];

                $response = $this->storeFile(
                    file: $file,
                    location: config("settings")['file_path']['account']['path'],
                );

                if (isset($response['status'])) {
                    $fileRecord = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => 'file',
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);


                    $account->file()->save($fileRecord);
                }
            }
        }

        return back()->with(response_status('Account created successfully '));
    }

    public function edit($id)
    {

        return view('admin.account.edit',[

            'title'                 =>  translate('create Accounts'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Accounts'=> 'admin.account.list' , 'Update Account' => null],
            'account'               =>  Account::findOrFail($id)

        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'                    => 'required|integer|exists:accounts,id',
            'name'                  => 'required|string|max:191',
            'balance'               => 'numeric|min:0',
            'custom_inputs'         => 'required|array',
            'custom_inputs.*.key'   => 'string|max:255',
            'custom_inputs.*.value' => 'string|max:255',
            'custom_inputs.*.file'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $customInputs = $request->input('custom_inputs');

        $account = Account::findOrFail($request->input('id'));

        $account->name          = $request->input('name');
        $account->balance       = $request->input('balance');
        $account->custom_inputs = json_encode($customInputs);
        $account->save();




        foreach($customInputs as $customInput){

            if (isset($customInput['file'])) {

                $file = $customInput['file'];

                $response = $this->storeFile(
                    file: $file,
                    location: config("settings")['file_path']['account']['path'],
                );

                if (isset($response['status'])) {
                    $fileRecord = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => 'file',
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);


                    $account->file()->save($fileRecord);
                }
            }
        }

        return back()->with(response_status('Account updated successfully '));
    }

    public function addBalance(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $account = Account::findOrFail($request->input('id'));

        $account->balance += $request->input('amount');
        $account->save();

        return back()->with(response_status('Account balance updated successfully '));

    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        if($account->balance != 0) return back()->with(response_status('Empty your account first ' ,'error' ));

        $account->delete();

        return back()->with(response_status('Account deleted successfully '));
    }

}
