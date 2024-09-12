<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KYCStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\KycService;
use App\Http\Services\Admin\TemplateActivityService;
use App\Http\Services\Admin\TransactionService;
use App\Http\Services\Admin\WebhookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Traits\ModelAction;
use App\Traits\Notifyable;


class ActivityHistoryController extends Controller
{


    use ModelAction ,Notifyable;

    public function __construct(
        protected TransactionService $transactionService,
        protected TemplateActivityService $templateActivityService,
        protected KycService $kycService,
        protected WebhookService $webhookService
    )
    {


        $this->middleware(['permissions:view_report'])
            ->only([
                    "templateReport",
                    'kycReport',
                    'kycDetails',
                    'kycUpdate',
                ]);

        $this->middleware(['permissions:delete_report'])
             ->only([
                    "templateReportdestroy",
                ]);
    }



    /**
     * Templates report
     *
     * @return View
     */
    public function templateReport() :View{
        return view('admin.report.template_report',$this->templateActivityService->getReport());
    }


    /**
     * Template report delete
     *
     * @param string | int $id
     */
    public function templateReportdestroy(string|int $id): RedirectResponse{
        $response = $this->templateActivityService->destroy($id);
        return  back()->with(response_status('Item deleted succesfully'));
    }




    /**
     * KYC Report and statistics
     *
     * @return View
     */
    public function kycReport(): View{
        return view('admin.report.kyc_report',$this->kycService->getReport());
    }

    /**
     * Get KYC Details View
     *
     * @param integer|string $id
     * @return View
     */
     public function kycDetails(int|string $id): View{

        return view('admin.report.kyc_details',[
            'breadcrumbs'     => ['Home'=>'admin.home','Verification Logs'=> "admin.kyc.report.list" ,'Details' => null],
            'title'           => 'Details',
            "report"          => $this->kycService->getSpecificReport($id)
        ]);
    }


    /**
     * Update KYC details
     *
     * @param Request $request
     * @return RedirectResponse
     */
     public function kycUpdate(Request $request): RedirectResponse{
        $request->validate([
            "id"        => ['required',"exists:kyc_logs,id"],
            "status"    => ['required',Rule::in([KYCStatus::value('APPROVED'),KYCStatus::value('REJECTED')])],
            "notes"     => ['required',"string",'max:255'],
        ]);

        $report   = $this->kycService->getSpecificReport($request->input("id"),KYCStatus::REQUESTED);
        $response = $this->kycService->update($report ,$request->except(['_token']));
        return back()->with(response_status("Updated successfully"));

    }
}
