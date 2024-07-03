@extends('layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
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

    <!-- new code start -->

    <div class="content-section mb-4">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="i-card-md">
                    <div class="card-header">
                        <h4 class="card-title">Prompt templates</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="content-category">Content Category</label> <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This is for making ai content."><i class="bi bi-info-circle-fill opacity-75 ms-1"></i></span>
                                        <select name="content-category" id="content-category" class="select2">
                                            <option>Category One</option>
                                            <option>Category Two</option>
                                            <option>Category Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="sub-category">Sub Category</label> <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This is for making ai content."><i class="bi bi-info-circle-fill opacity-75 ms-1"></i></span>
                                        <select name="sub-category" id="sub-category" class="select2">
                                            <option>Sub Category One</option>
                                            <option>Sub Category Two</option>
                                            <option>Sub Category Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row row-cols-xl-6 row-cols-lg-4 row-cols-md-4 g-3 mt-1">
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-magic"></i>
                                    </div>
                                    <h5>Suggested</h5>
                                    <p>AI's impact on social media, from personalized content curation</p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-facebook"></i>
                                    </div>
                                    <h5>Facebook</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-twitter"></i>
                                    </div>
                                    <h5>Twitter</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-instagram"></i>
                                    </div>
                                    <h5>Instagram</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-linkedin"></i>
                                    </div>
                                    <h5>Linkedin</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-tiktok"></i>
                                    </div>
                                    <h5>Tiktok</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-lightbulb"></i>
                                    </div>
                                    <h5>Inspirational</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>
                                    <h5>Educational</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                            <div class="col">
                                <button class="prompt-btn">
                                    <div class="icon">
                                        <i class="bi bi-cup-hot-fill"></i>
                                    </div>
                                    <h5>Restaurant</h5>
                                    <p>AI's impact on social media, from personalized content curation </p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="i-card-md">
                    <div class="card-header">
                        <h4 class="card-title">Ai Content Generator</h4>
                    </div>
                    <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="prompt">Write your prompt</label>
                                    <textarea placeholder="What’s on your mind, Olivia" class="bg-light radius-16" id="prompt"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <span id="rangeValue">0</span>
                                    <input class="range" type="range" value="0" min="0" max="1000" onChange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)"></input>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-inner">
                                    <label for="lang">Select language</label>
                                    <select name="lang" id="lang" class="select2">
                                        <option>Eng</option>
                                        <option>Bng</option>
                                        <option>Spn</option>
                                    </select>
                                </div>
                            </div>  
                            <div class="col-lg-4">
                                <div class="form-inner">
                                    <label for="tone">Content tone</label> <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This is for making ai content."><i class="bi bi-info-circle-fill opacity-75 ms-1"></i></span>
                                    <select name="tone" id="tone" class="select2">
                                        <option>Eng</option>
                                        <option>Bng</option>
                                        <option>Spn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-inner">
                                    <label for="tone">Ai Level</label> <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This is for making ai content."><i class="bi bi-info-circle-fill opacity-75 ms-1"></i></span>
                                    <select name="level" id="level" class="select2">
                                        <option>Eng</option>
                                        <option>Bng</option>
                                        <option>Spn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <div class="form-inner">
                                    <label for="tone">Content tone</label> <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This is for making ai content."><i class="bi bi-info-circle-fill opacity-75 ms-1"></i></span>
                                    <input type="text" placeholder="Enter your content name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="i-card-md">
                    <div class="card-header">
                        <h4 class="card-title">Your Content</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center g-2 mb-4">
                            <div class="col-auto flex-grow-1">
                                <input class="project-title" type="text" id="title" name="title" placeholder="Your project title..." value="">
                            </div>

                            <div class="col-auto">
                                <button type="button" class="icon-btn icon-btn-sm border-0 shadow-sm rounded-circle p-0 me-2" data-bs-title="Download" id="downloadDropdown" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></button>
                            </div>

                            <div class="col-auto">
                                <button type="button" class="icon-btn icon-btn-sm border-0 shadow-sm rounded-circle move_to_folder_btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Move to folder" onclick="showSaveToFolderModal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg></button>
                            </div>

                            <div class="col-auto">
                                <button type="button" class="icon-btn icon-btn-sm border-0 shadow-sm rounded-circle copyBtn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy Contents"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="icon-btn icon-btn-sm border-0 shadow-sm rounded-circle content-form-submit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Save Changes"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg></button>
                            </div>
                        </div>
                        <div class="form">
                            <div class="form-inner">
                                <textarea name="generate-content" id="" cols="30" rows="10" placeholder="Generated Content" class="rounded-8"></textarea>
                            </div>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <select name="lang" id="lang2" class="select2">
                                        <option>Eng</option>
                                        <option>Bng</option>
                                        <option>Spn</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <button class="i-btn btn--lg btn--primary capsuled w-100" type="submit">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- new code end -->

    <div>
        <div class="i-card-md">
          <div class="card-header">
            <h4 class="card-title">
                {{translate(Arr::get($meta_data,'title'))}}
            </h4>
            <div class="d-flex align-items-center gap-2">
                <a href="#generateContent" class="i-btn primary btn--sm capsuled create">
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
                                        <input  type="checkbox" class="status-update form-check-input"
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
                                        <a href="javascript:void(0);" data-href="{{route('user.ai.content.destroy',$content->id)}}"  class="icon-btn icon-btn-sm primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
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
                                <label for="aiContent" class="form-label" >
                                    {{translate('Content')}} <small class="text-danger">*</small>
                                </label>
                                <textarea placeholder='{{translate("Type Here...")}}' name="content" id="aiContent" cols="30" rows="10"></textarea>
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

        function rangeSlide(value) {
            document.getElementById('rangeValue').textContent = value;
        }

        $(".select2").select2({
            placeholder:"{{translate('Select Item')}}",
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

