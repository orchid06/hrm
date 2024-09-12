<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentMethod;
use App\Models\AffiliateLog;
use App\Models\AiTemplate;
use App\Models\CreditLog;
use App\Models\KycLog;
use App\Models\Package;
use App\Models\PaymentLog;
use App\Models\PostWebhookLog;
use App\Models\Subscription;
use App\Models\TemplateUsage;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{


    protected $user ,$subscription,$accessPlatforms,$webhookAccess;

    public function __construct(){

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }




    /**
     * ai template templates report
     *
     * @return View
     */
    public function templateReport() :View {


        return view('user.report.word_report',[

            'meta_data'       => $this->metaData(['title'=> translate("Templates Reports")]),

            "genarated_words" => TemplateUsage::filter(['template:slug'])
                                  ->where('user_id',$this->user->id)
                                  ->date()
                                  ->sum("total_words"),

            "reports"         => TemplateUsage::with(['template','user'])
                                    ->filter(['template:slug'])
                                    ->where('user_id',$this->user->id)
                                    ->date()
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),



        ]);


    }


    /**
     * transaction report
     *
     * @return View
     */
    public function transactionReport() :View{


        return view('user.report.transaction_report',[


            'meta_data'       => $this->metaData(['title'=> translate("Transaction Reports")]),
            "reports"         => Transaction::with(['user','admin','currency'])
                                    ->where('user_id',$this->user->id)
                                    ->search(['remarks','trx_code'])
                                    ->filter(['trx_type'])
                                    ->date()
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

        ]);


    }





    /**
     * Credit report
     *
     * @return View
     */
    public function kycReport() :View{


        return view('user.report.kyc_report',[

            'meta_data'       => $this->metaData(['title'=> translate("KYC Reports")]),
            'title'           => translate('Verification request'),
            "reports"         => KycLog::with(['user','file'])
                                    ->where('user_id',$this->user->id)
                                    ->search(['notes'])
                                    ->filter(['status'])
                                    ->date()
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

        ]);

    }

}
