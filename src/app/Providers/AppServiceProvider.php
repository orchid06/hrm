<?php

namespace App\Providers;

use App\Enums\ClockStatusEnum;
use App\Enums\LeaveStatus;
use App\Enums\MenuVisibilty;


use App\Models\Admin\Menu;
use App\Models\Admin\Page;
use App\Models\Attendance;
use App\Models\Core\Language;

use App\Models\KycLog;
use App\Models\Leave;
use App\Models\PaymentLog;
use App\Models\Ticket;
use App\Models\WithdrawLog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Query\Builder as QueryBuilder;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {

            Paginator::useBootstrap();

            if(env("APP_DEBUG")){
                Config::set('sentry',[
                    'dns' => site_settings('sentry_dns')
                ]);
            }


            view()->composer('admin.partials.sidebar', function ($view)  {

               $currentMonth     = now()->month;

               $pending_clock_in  =  Attendance::where('clock_in_status' , ClockStatusEnum::PENDING->status())
                                                ->whereMonth('created_at', $currentMonth)
                                                ->count();

               $pending_clock_out =  Attendance::where('clock_out_status' , ClockStatusEnum::PENDING->status())
                                                ->whereMonth('created_at', $currentMonth)
                                                ->count();

                $pending_attendance = $pending_clock_in + $pending_clock_out;

                $pending_leave_requests = Leave::where('status' , LeaveStatus::pending->status())
                                                ->whereMonth('created_at', $currentMonth)
                                                ->count();

                $view->with([
                    'pending_tickets'       => Ticket::pending()->count(),
                    'pending_kycs'          => KycLog::pending()->count(),
                    'pending_attendance'    => $pending_attendance,
                    'pending_leave'         => $pending_leave_requests
                ]);
            });


            view()->composer('frontend.partials.header', function ($view)  {

                $view->with([
                    'menus'      => getCachedMenus()
                                              ->whereIn('menu_visibility',[(string)MenuVisibilty::BOTH->value,(string)MenuVisibilty::HEADER->value]),

                    'pages'      => Page::active()
                                          ->orderBy('serial_id')
                                          ->header()
                                          ->get(),
                ]);
            });





            view()->composer('frontend.partials.footer', function ($view)  {

                $view->with([
                    'menus'      => getCachedMenus()
                                        ->whereIn('menu_visibility',[(string)MenuVisibilty::BOTH->value ,(string) MenuVisibilty::FOOTER->value ]),

                    'pages'      => Page::active()
                                        ->orderBy('serial_id')
                                        ->footer()
                                        ->get(),
                ]);
            });



            view()->share([
                'languages'       => Language::active()->get(),
            ]);



        } catch (\Throwable $th) {

        }


    }

    private function _defineMacros(){
        QueryBuilder::macro('whereUid', function ($uid) {
            return $this->where('uid', $uid);
        });
    }
}
