<?php
namespace App\Http\Services\Admin;

use App\Enums\KYCStatus;
use App\Enums\StatusEnum;
use App\Enums\WithdrawStatus;
use App\Models\KycLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class KycService
{


    /**
     * Get all KYC log  statistics
     *
     * @return array
     */
    public function getReport(): array{

        $graphData = new Collection();
        KycLog::date()
            ->filter(["user:username"])
            ->whereYear('created_at',  date('Y'))
            ->selectRaw("MONTH(created_at) as month, 
                            MONTHNAME(created_at) as months,
                            COUNT(*) as total,
                            COUNT(CASE WHEN status   ='3'  THEN id END) AS pending,
                            COUNT(CASE WHEN status   ='2'  THEN id END) AS rejected,
                            COUNT(CASE WHEN status   ='1'  THEN id END) AS approved
                            "
                        )
            ->groupBy('month', 'months')
            ->orderBy('month')
            ->chunk(1000, function (Collection $logs) use (&$graphData) : void {
                $graphData  = $logs->map(fn(KycLog $log) : array =>
                        [$log->months =>  [
                            'total'     => $log->total,
                            'pending'   => $log->pending,
                            'approved'  => $log->approved,
                            'rejected'  => $log->rejected,
                        ]]
                );
            });

           return  [
                    'breadcrumbs'     =>  ['Home'=>'admin.home','KYC Reports'=> null],
                    'title'           => 'KYC Reports',
                    "reports"         =>  KycLog::with(['user'])
                                                ->search(['notes'])
                                                ->filter(["user:username","status"])
                                                ->date()               
                                                ->latest()
                                                ->paginate(paginateNumber())
                                                ->appends(request()->all()),
                    
                    'graph_data'       => sortByMonth($graphData->collapse()->all(),true,
                                            [
                                                'total'     => 0,
                                                'pending'   => 0,
                                                'approved'  => 0,
                                                'rejected'  => 0,
        
                                            ]), 
    
                    'summaries'       => [
    
                                            'total'          => KycLog::filter(["user:username"])
                                                                        ->date()
                                                                        ->count(),   
                                            'pending'        => KycLog::pending()
                                                                        ->filter(["user:username"])
                                                                        ->date()
                                                                        ->count(),
                                                                                                
                                            
                                            'approved'       => KycLog::approved()
                                                                        ->filter(["user:username"])
                                                                        ->date()
                                                                        ->count(),
                            
                                            'rejected'        => KycLog::rejected()
                                                                        ->filter(["user:username"])
                                                                        ->date()
                                                                        ->count(),

                                            ],
                ];
    
    }




    /**
     * Get specific KYC report
     *
     * @param integer|string $id
     * @param WithdrawStatus|null $status
     * @return KycLog|null
     */
    public function getSpecificReport(int|string $id , ?WithdrawStatus $status = null): ?KycLog{

        return  KycLog::with(['user','file'])
                                  ->when($status , fn(Builder $q): Builder => $q->where("status",(string)$status->value))
                                  ->findOrfail($id);
    } 




    /**
     * Update a specific KYC log
     *
     * @param KycLog $log
     * @param array $request
     * @return boolean
     */
    public function update(KycLog $log , array $request): bool{

        $log->status  = Arr::get($request,'status');
        $log->notes   = Arr::get($request,'notes');
        $log->save();

        if($log->user && $log->status == KYCStatus::value('APPROVED',true)) {
            $log->user->is_kyc_verified  = StatusEnum::true->status();
            $log->user->save();
        }


        #todo : notify users

        // $code = [
        //     "name"            => $report->user->name,
        //     "status"          => Arr::get(array_flip(WithdrawStatus::toArray()),$report->status ,"Pending")
        // ];

        // $route      =  route("user.kyc.report.list");

        // $notifications = [

        //     'database_notifications' => [
                
        //         'action' => [SendNotification::class, 'database_notifications'],
        //         'params' => [
        //            [ $report->user, 'KYC_UPDATE', $code, $route ]
        //         ],
        //     ],
          
        //     'email_notifications' => [

        //         'action' => [SendMailJob::class, 'dispatch'],
        //         'params' => [
        //            [$report->user, 'KYC_UPDATE', $code],
        //         ],
        //     ],
        //     'sms_notifications' => [

        //         'action' => [SendSmsJob::class, 'dispatch'],
        //         'params' => [
        //             [$report->user, 'KYC_UPDATE', $code],
        //         ],
        //     ],
        // ];

        // $this->notify($notifications);


        return true;
    }


}
