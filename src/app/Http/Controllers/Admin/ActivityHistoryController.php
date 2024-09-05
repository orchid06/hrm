<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DepositStatus;
use App\Enums\KYCStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\AffiliateService;
use App\Http\Services\Admin\CreditReportService;
use App\Http\Services\Admin\DepositReportService;
use App\Http\Services\Admin\KycService;
use App\Http\Services\Admin\SubscriptionReportService;
use App\Http\Services\Admin\TemplateActivityService;
use App\Http\Services\Admin\TransactionService;
use App\Http\Services\Admin\WebhookService;
use App\Http\Services\Admin\WithdrawReportService;
use App\Http\Services\PaymentService;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\CreditLog;
use App\Traits\ModelAction;
use Illuminate\Support\Arr;
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
                    'webhookReport'
                ]);

        $this->middleware(['permissions:delete_report'])
             ->only([
                    "templateReportdestroy",
                    'destroyWebhook'
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
            'breadcrumbs'     => ['Home'=>'admin.home','KYC Logs'=> "admin.kyc.report.list" ,'Details' => null],
            'title'           => 'KYC Details',
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



    /**
     * Get webhook report
     *
     * @return View
     */
    public function webhookReport(): View{
        return view('admin.report.webhook_report',$this->webhookService->getReport());
    }


    /**
     * Destory a specific webhook
     *
     * @param integer|string $id
     * @return RedirectResponse
     */
     public function destroyWebhook(int|string $id): RedirectResponse{
        $response = $this->webhookService->destroy($id);
        return  back()->with(response_status('Deleted Successfully'));
    }




}
