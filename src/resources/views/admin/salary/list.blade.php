@extends('admin.layouts.master')
@section('content')
<div class="row g-4 mb-4">

    @if(request()->routeIs("admin.salary.list"))
     @forelse($users as $user)
        <div class="col-xl-3">
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
                            <span class="i-badge capsuled info">{{($user->userDesignation->designation->name)}}</span>
                            <span class="i-badge capsuled success">{{($user->userDesignation->designation->department->name)}}</span>
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
    @endif

</div>

@endsection


@section('modal')

@endsection

@push('script-include')

@endpush

@push('script-push')

@endpush
