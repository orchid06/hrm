@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@php
 $user = auth_user('web');
@endphp

<div>
    <div class="i-card-md">

      <div class="card-header">

            <h4 class="card-title">
                {{translate(Arr::get($meta_data,'title'))}}
            </h4>
            <div class="d-flex align-items-center gap-2">
                <button class="icon-btn icon-btn-lg bg-info-solid text--light circle" type="button" data-bs-toggle="collapse" data-bs-target="#tableFilter"     aria-expanded="false"
                    aria-controls="tableFilter">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
      </div>

      <div class="collapse" id="tableFilter">
        <div class="search-action-area">
            <div class="search-area">
                <form action="{{route(Route::currentRouteName())}}">

                    <div class="form-inner">
                        <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder='{{translate("Filter by date")}}'>
                    </div>

            
                    <div class="form-inner">
                        <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by email , name , or phone")}}'>
                    </div>


                    <div class="d-flex gap-2">
                        <button type="submit" class="i-btn primary btn--lg rounded">
                            <i class="bi bi-search"></i>
                        </button>

                        <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--lg danger rounded">
                            <i class="bi bi-arrow-repeat"></i>
                        </a>
                    </div>

                </form>
            </div>
        </div>
      </div>

      <div class="card-body px-0">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">
                            #
                        </th>
                        <th scope="col">
                                {{translate("Users")}}
                        </th>

                        <th scope="col">
                            {{translate("Joined At")}}
                        </th>

                        <th scope="col">
                            {{translate("Earning Amount")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($affliateUsers as $affliateUser)
                        <tr>
                            <td data-label="#">

                                {{$loop->iteration}}
                            </td>
                            <td data-label="{{translate('Users')}}">
                                <a href="{{route('user.affiliate.report.list',['referral' => $affliateUser->username])}}">
                                    {{$affliateUser->name}}
                                </a>
                                
                            </td>

                            <td data-label="{{translate('Creation Time')}}">
                                {{get_date_time($affliateUser->created_at)}}
                            </td>

                            <td data-label="{{translate('Earning Amount')}}">

                                {{($affliateUser->affiliateLogs->count() > 0 ?  @num_format(
                                    number : @$affliateUser->affiliateLogs->sum('commission_amount')??0,
                                    calC   : true
                                ) : 'N/A' )}}
                            </td>
                        
                        </tr>
                    @empty
                        <tr>
                            <td class="border-bottom-0" colspan="90">
                                @include('admin.partials.not_found')
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
      </div>

    </div>

    <div class="Paginations">
        {{ $affliateUsers->links() }}
    </div>
</div>

@endsection


@push('script-include')
   <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".referral").select2({

        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });

	})(jQuery);
</script>
@endpush





