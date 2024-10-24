@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <form hidden id="bulkActionForm" action='{{route("admin.account.bulk")}}' method="post">
                    @csrf
                    <input type="hidden" name="bulk_id" id="bulkid">
                    <input type="hidden" name="value" id="value">
                    <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_account') || check_permission('update_account') ||
                check_permission('delete_account'))
                <div class="col-md-6 d-flex justify-content-start">
                    @if(check_permission('update_account') || check_permission('delete_account'))
                    <div class="i-dropdown bulk-action d-none">
                        <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="las la-cogs fs-15"></i>
                        </button>
                        <ul class="dropdown-menu">

                            @if(check_permission('update_account'))
                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                            <li>
                                <button type="button" name="bulk_status" data-type="status" value="{{$v}}"
                                    class="dropdown-item bulk-action-btn"> {{translate($k)}}</button>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    @endif

                    @if(check_permission('create_account'))

                    <div class="action">
                        <a href="{{route('admin.account.create')}}" class="add i-btn btn--sm success">
                            <i class="las la-plus me-1"></i> {{translate('Add New account')}}
                        </a>
                    </div>

                    @endif

                </div>
                @endif
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">
                            <div class="form-inner">
                                <input name="search" value="{{request()->input('search')}}" type="search"
                                    placeholder="{{translate('Search by name')}}">
                            </div>
                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route(Route::currentRouteName())}}" class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container position-relative">
            @include('admin.partials.loader')
            <table>
                <thead>
                    <tr>

                        <th scope="col">
                            {{translate('Name')}}
                        </th>

                        <th scope="col">
                            {{translate('Balance')}}
                        </th>

                        <th scope="col">
                            {{translate('Options')}}
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($accounts as $account)
                    <tr>

                        <td data-label='{{translate("Title")}}'>
                            <p>
                                {{($account->name)}}
                            </p>
                        </td>

                        <td data-label='{{translate("Balance")}}'>
                            <p>
                                {{($account->balance)}}
                            </p>
                        </td>

                        <td data-label='{{translate("Options")}}'>
                            <div class="table-action">
                                @if(check_permission('update_account') || check_permission('delete_account') )

                                @if(check_permission('update_account') )
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Add balance')}}" href="javascript:void(0);"
                                    data-account="{{$account}}" class="addBalance icon-btn success">
                                    <i class="las la-plus me-1"></i>
                                    <i class="las la-wallet"></i>
                                </a>
                                @endif

                                @if(check_permission('update_account') )
                                <a href="{{route('admin.account.edit' , $account->id)}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Update Account')}}"
                                     class="update icon-btn warning"><i class="las la-pen"></i>
                                </a>
                                @endif

                                @if(check_permission('delete_account'))
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Delete')}}"
                                    data-href="{{route('admin.account.destroy',$account->id)}}"
                                    class="pointer delete-item icon-btn danger">
                                    <i class="las la-trash-alt"></i>
                                </a>
                                @endif
                                @else
                                {{translate('N/A')}}
                                @endif

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td class="border-bottom-0" colspan="7">
                            @include('admin.partials.not_found',['custom_message' => "No accounts found!!"])
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="addBalance" tabindex="-1" aria-labelledby="addBalance"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add Balance')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.account.balance.add')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="id">

                    <div class="form-inner">
                        <label for="name">{{translate('Name')}}</label>
                        <input disabled type="text" name="name" id="name" >
                    </div>

                    <div class="form-inner">
                        <label for="amount">{{translate('Amount')}} <small class="text-danger">*</small></label>
                        <input type="number" name="amount" id="amount" value="{{old('amount')}}" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Submit")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')

@endpush

@push('script-push')
<script>
    (function ($) {
        "use strict";

        $(document).on('click', '.addBalance', function (e) {

            var account = JSON.parse($(this).attr("data-account"))
            var modal = $('#addBalance')

            modal.find('input[name="id"]').val(account.id)
            modal.find('input[name="name"]').val(account.name)

            modal.modal('show')
        })

    })(jQuery);
</script>
@endpush
