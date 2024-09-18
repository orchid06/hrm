@extends('admin.layouts.master')
@section('content')
<div class="row g-4 mb-4">

    <div class="w-100 d-flex justify-content-end">
        <form class="d-flex justify-content-end align-items-center gap-3" action="{{route(Route::currentRouteName())}}" method="get">
            <select name="user_id" id="user_id" class="select2" placeholder="{{translate('Select a User')}}">
                <option value="">{{translate('Select a User')}}</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" {{request()->input('user_id')== $user->id ?'selected' : ''}}>
                    {{$user->name}}
                </option>
                @endforeach
            </select>

            <button class="i-btn btn--sm info">
                <i class="las la-sliders-h"></i>
            </button>
            <a href="{{route(Route::currentRouteName())}}" class="i-btn btn--sm danger">
                <i class="las la-sync"></i>
            </a>
        </form>

    </div>


     @forelse($users as $user)
        <div class="col-xl-4">
            <div class="i-card-md h-440 mb-4">

                <div class="card-body">

                    <div class="d-flex flex-column align-items-center justify-content-start border--bottom mb-4 gap-2 bg--light rounded-3 gap-3 p-3">
                        <div class="user-profile-image bg--light">
                            <img src="{{ imageURL($user->file,'profile,user',true) }}" alt="profile.jpg">
                        </div>
                        <div class="text-center">
                            <h6 class="mb-1">

                                <a   href="{{route('admin.user.show', $user->uid)}}"   data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('View profile')}}" class="icon-btn warning">
                                    {{$user->name}}</i>
                                </a>
                            </h6>
                            <span class="i-badge capsuled info">{{(@$user->userDesignation->designation->name)}}</span>
                            <span class="i-badge capsuled success">{{(@$user->userDesignation->designation->department->name)}}</span>
                        </div>
                    </div>

                    <a href="{{route('admin.salary.create',$user->uid)}}" class="i-btn btn--md btn--primary w-100 update-profile" ><i class="bi bi-person-gear fs-18 me-3"></i>
                            {{translate("Set Salary")}}
                    </a>
                </div>
            </div>
        </div>
        @empty
            @include('admin.partials.not_found',['custom_message' => "No Employee found!!"])
        @endforelse


</div>

@endsection


@section('modal')

@endsection

@push('script-include')

@endpush

@push('script-push')
<script>
    (function ($) {
        "use strict"

        $(".select2").select2({
                placeholder: "{{translate('Select a User')}}",
        })

    })(jQuery);

</script>


@endpush
