@extends('admin.layouts.master')

@section('content')
    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">
                            <div class="form-inner">
                                <input name="search" value='{{request()->input("search")}}' type="search" placeholder="{{translate('Search by name')}}">
                            </div>
                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route('admin.mailGateway.list')}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-container position-relative">
                @include('admin.partials.loader')
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>
                            <th scope="col">
                                {{translate('Default')}}
                            </th>
                            <th scope="col">
                                {{translate('Updated By')}}
                            </th>
                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gateways as $gateway)
          
                            <tr>
                                <td data-label="#">
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate('Name')}}">
                                    {{strtoupper($gateway->name)}}
                                </td>
                                <td data-label='{{translate("Status")}}'>
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_gateway') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.mailGateway.update.status') }}"
                                            data-status="{{ $gateway->default == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$gateway->uid}}" {{$gateway->default ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch-{{$gateway->id}}" >
                                        <label class="form-check-label" for="status-switch-{{$gateway->id}}"></label>
                                    </div>
                                </td>
                                <td data-label='{{translate("Updated By")}}'>
                                    <span class="i-badge capsuled info">
                                        {{$gateway->updatedBy->name}}
                                    </span>
                                </td>
                                <td data-label='{{translate("Options")}}'>
                                    <div class="table-action">
                                        @if(check_permission('update_gateway') &&  $gateway->code != "104PHP")
                                          <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate("Update")}}" href="{{route('admin.mailGateway.edit',$gateway->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
                                        @else
                                            {{translate('N/A')}}
                                        @endif
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
@endsection



