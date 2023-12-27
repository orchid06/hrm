@extends('layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')

     @php
         $flag           = 0;
         $user           = auth_user('web');
         $subscription   = $user->runningSubscription;
         $templateAccess = $subscription
                            ? (array)subscription_value($subscription,"template_access",true)
                            : [];

     @endphp
    <div>
        <div class="i-card-md">
          <div class="card-header">
                <h4 class="card-title">
                    {{translate(Arr::get($meta_data,'title'))}}
                </h4>

                <div class="d-flex align-items-center gap-2">
                    <a   href="javascript:void(0)" class="i-btn primary btn--sm capsuled create">
                        <i class="bi bi-plus-lg"></i>
                        {{translate('Create New')}}
                    </a>
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
                                <th scope="col">{{translate('Name')}}</th>
                                <th scope="col">{{translate('Status')}}</th>
                                <th scope="col">{{translate('Action')}}</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse ($contents as $content)
                                    <tr>
                                        <td data-label="#">
                                            {{$loop->iteration}}
                                        </td>
                                        <td data-label='{{translate("name")}}'>
                                            {{$content->name}}
                                        </td>

                                        <td data-label='{{translate("Status")}}'>
                                            <div class="form-check form-switch switch-center">
                                                <input {{!check_permission('update_content') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                    data-column="status"
                                                    data-route="{{ route('user.ai.content.update.status') }}"
                                                    data-status="{{ $content->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                    data-id="{{$content->uid}}" {{$content->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                                id="status-switch-{{$content->id}}" >
                                                <label class="form-check-label" for="status-switch-{{$content->id}}"></label>
                                            </div>
                                        </td>


                                        <td data-label='{{translate("Action")}}'>

                                                <div class="table-action">
                                                    <a href="javascript:void(0);" data-content ="{{$content}}"
                                                        class="icon-btn icon-btn-sm info update">
                                                        <i class="bi bi-pen"></i>
                                                    </a>

                                                    <a  href="javascript:void(0);" data-href="{{route('user.ai.content.destroy',$content->id)}}" data-toggle="tooltip" data-placement="top" title="{{translate('Delete')}}"
                                                        class="icon-btn icon-btn-sm danger delete-item">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
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
            {{ $contents->links() }}
        </div>
    </div>

    <div  class="ai-section d-none">
          @include('partials.prompt_content',['content_route' => route("user.ai.content.store")])
    </div>


@endsection


@section('modal')

@include('modal.delete_modal')

<div class="modal fade" id="content-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="content-form"   aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add Content')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>

            <form action="{{route('user.ai.content.store')}}" id="contentForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <input disabled  hidden name="id" type="text">
                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="name" class="form-label" >
                                    {{translate('Name')}} <small class="text-danger">*</small>
                                </label>
                                <input required type="text" placeholder="{{translate('Name')}}" id="name" name="name" value="{{old('name')}}">

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="content" class="form-label" >
                                    {{translate('Content')}} <small class="text-danger">*</small>
                                </label>
                                <textarea placeholder='{{translate("Type Here...")}}' name="content" id="content" cols="30" rows="10"></textarea>
                            </div>
                        </div>
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

@endsection


@push('script-include')
    @include('partials.ai_content_script');
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".select2").select2({
            placeholder:"{{translate('Select Category')}}",
        })

        $(".selectTemplate").select2({
            placeholder:"{{translate('Select Template')}}",
        })
        $(".sub_category_id").select2({
            placeholder:"{{translate('Select Sub Category')}}",
        })


        $(document).on('click','.create',function(e){
            if({{count($templateAccess)}} > 0){
                $('.ai-section').fadeToggle(1000).toggleClass('d-none');;
            }
            else{
                toastr('{{translate("AI template access unavailable. Ensure an active subscription for utilization. Thank you for your understanding")}}','danger')
            }
        });


	})(jQuery);
</script>
@endpush
