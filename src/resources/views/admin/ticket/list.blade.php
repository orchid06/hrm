@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">
    <div class="col">
        <div class="i-card-sm style-2 warning">
          <div class="card-info">
            <h3>
                {{Arr::get($counter,'pending',0)}}
            </h3>
            <h5 class="title">
               {{translate("Pending Ticket")}}
            </h5>
            <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::PENDING->value])}}" class="i-btn btn--sm btn--outline">
              {{translate("View All")}}
           </a>
          </div>
          <div class="icon">
            <i class="las la-comment-slash"></i>
          </div>
        </div>
    </div>
    <div class="col">
      <div class="i-card-sm style-2 danger">
        <div class="card-info">
          <h3> {{Arr::get($counter,'closed',0)}}</h3>
          <h5 class="title">
             {{translate("Closed Ticket")}}
          </h5>
          <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::CLOSED->value])}}" class="i-btn btn--outline btn--sm">
            {{translate("View All")}}
         </a>
        </div>
        <div class="icon">
            <i class="las la-comment"></i>
        </div>
      </div>
    </div>
    <div class="col">
        <div class="i-card-sm style-2 info">
          <div class="card-info">
            <h3>{{Arr::get($counter,'hold',0)}}</h3>
            <h5 class="title">
                {{translate("Holds Ticket")}}
            </h5>
            <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::HOLD->value])}}" class="i-btn btn--outline btn--sm">
               {{translate("View All")}}
            </a>
          </div>
          <div class="icon">
            <i class="las la-sms"></i>
          </div>
        </div>
    </div>
    <div class="col">
      <div class="i-card-sm style-2 success">
        <div class="card-info">
          <h3>{{Arr::get($counter,'solved',0)}}</h3>
          <h5 class="title">
             {{translate("Solved Ticket")}}
          </h5>
          <a href="{{route('admin.ticket.list',['status' => App\Enums\TicketStatus::SOLVED->value])}}" class="i-btn btn--outline btn--sm">
             {{translate("View All")}}
          </a>
        </div>
        <div class="icon">
            <i class="las la-envelope-open"></i>
        </div>
      </div>
    </div>
</div>
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                @if(check_permission('create_category'))
                    <div class="col-md-6 col-6 d-flex justify-content-start">
                        @if(check_permission('create_category'))
                            <div class="action">
                                <a href="{{route('admin.ticket.create')}}" class="i-btn btn--sm success">
                                    <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="filter-wrapper">
                        <button class="i-btn btn--primary btn--sm filter-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="las la-filter"></i>
                        </button>
                        <div class="filter-dropdown">
                            <form action="{{ route(Route::currentRouteName()) }}" method="get">
                                <div class="form-inner">
                                    <input type="text" id="datePicker" name="date" value="{{ request()->input('date') }}" placeholder="{{ translate('Filter by date') }}">
                                </div>
                                <div class="form-inner">
                                    <input type="text" name="ticket_number" value="{{ request()->input('ticket_number') }}" placeholder="{{ translate('Enter Ticket Number') }}">
                                </div>
                                <div class="form-inner">
                                    <select name="user" id="user" class="user">
                                        <option value="">{{ translate('Select User') }}</option>
                                        @foreach(system_users() as $user)
                                            <option {{ Arr::get($user, 'username', null) == request()->input('user') ? 'selected' : '' }} value="{{ Arr::get($user, 'username', null) }}">
                                                {{ Arr::get($user, 'name', null) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-inner">
                                    <select name="status" class="select2" id="status">
                                        <option value="">{{ translate('Select Status') }}</option>
                                        @foreach(App\Enums\TicketStatus::toArray() as $k => $v)
                                            <option {{ request()->input('status') == $v ? 'selected' : '' }} value="{{ $v }}">
                                                {{ ucfirst(strtolower($k)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-inner">
                                    <select name="priority" class="select-priority">
                                        <option value="">{{ translate('Select Priority') }}</option>
                                        @foreach(App\Enums\PriorityStatus::toArray() as $k => $v)
                                            <option {{ request()->input('priority') == $v ? 'selected' : '' }} value="{{ $v }}">
                                                {{ ucfirst(strtolower($k)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="i-btn btn--md info w-100">
                                    <i class="las la-sliders-h"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('admin.ticket.list') }}" class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container position-relative">
            @include('admin.partials.loader')
            <table >
                <thead>
                    <tr>
                        <th scope="col">
                           #
                        </th>
                       <th scope="col">
                            {{translate("Ticket Number")}}
                       </th>
                       <th scope="col">
                            {{translate("User")}}
                       </th>
                       <th scope="col">
                           {{translate("Subject")}}
                       </th>
                       <th scope="col">
                           {{translate("Status")}}
                       </th>
                       <th scope="col">
                           {{translate("Priority")}}
                       </th>
                       <th scope="col">
                           {{translate("Creation Time")}}
                       </th>
                       <th scope="col">
                           {{translate("Options")}}
                       </th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                            <tr>
                                <td data-label="#">

                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate('Ticket Number')}}">
                                    <a href="{{route('admin.ticket.show',$ticket->ticket_number)}}">
                                        {{$ticket->ticket_number}}
                                    </a>
                                </td>
                                <td data-label="{{translate('User')}}">
                                    <a href="{{route('admin.user.show', $ticket->user->uid)}}">
                                       {{$ticket->user?->name}}
                                    </a>
                                </td>
                                <td data-label="{{translate('Subject')}}">
                                    {{limit_words($ticket->subject,15)}}
                                </td>
                                <td data-label="{{translate('Status')}}">
                                    @php echo ticket_status($ticket->status) @endphp

                                </td>
                                <td data-label="{{translate('Priority')}}">
                                    @php echo priority_status($ticket->priority) @endphp
                                </td>
                                <td data-label="{{translate('Creation Time')}}">
                                    {{get_date_time($ticket->created_at)}}
                                </td>
                                <td data-label="{{translate('Options')}}">
                                    <div class="table-action">
                                        <a  href="{{route('admin.ticket.show',[$ticket->ticket_number])}}"  class="icon-btn success"><i class="las la-eye"></i></a>
                                        @if(check_permission('delete_ticket') )
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="{{translate('Delete')}}" data-href="{{route('admin.ticket.destroy',$ticket->id)}}" class="delete-item icon-btn danger">
                                            <i class="las la-trash-alt"></i></a>
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
        <div class="Paginations">
            {{ $tickets->links() }}

        </div>
    </div>
</div>

<h4 class="page-title mt-5">Update Your System</h4>
<div class="i-card-md mt-3">
    <div class="card--header">
        <h4 class="card-title">Be Aware !!! Before Update</h4>
    </div>
    <div class="card-body">
        <ul class="update-list">
            <li><i class="bi bi-check2-square"></i>You must take backup from your server (files & database)</li>
            <li><i class="bi bi-check2-square"></i>Make Sure You have stable internet connection</li>
            <li class="text-danger"><i class="bi bi-check2-square"></i>Do not close the tab while the process is running</li>
        </ul>
    </div>
</div>
<div class="i-card-md mt-3">
    <div class="card--header">
        <h4 class="card-title">Update Application</h4>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="d-flex align-items-center flex-md-nowrap flex-wrap gap-3 mb-4">
                    <div class="version">
                        <span>Current Version</span>
                        <h4>v4.0.2</h4>
                        <p>2023-12-18 09:45:23</p>
                    </div>
                    <div class="version latest">
                        <span>Latest Version</span>
                        <h4>v4.0.2</h4>
                        <p>2023-12-18 09:45:23</p>
                    </div>
                </div>
                <div class="mt-4 mb-4">
                    <label  for="image" class="feedback-file">
                        <input hidden  data-size = "100x100" type="file" name="image" id="image" class="preview">
                        <span><i class="bi bi-file-zip"></i>
                            {{translate("Update file")}}
                        </span>
                    </label>
                    <div class="image-preview-section">
                    </div>
                </div>
                <button class="i-btn btn--lg btn--primary update-btn" type="submit">Update Now</button>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="update-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 66 66" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M24.1 29.4c.3.2.8.1 1.1-.1L42.1 16c.2-.2.4-.5.4-.8s-.1-.6-.4-.8l-17-13.2c-.3-.2-.7-.3-1.1-.1-.3.2-.6.5-.6.9v4.4c-7.4.3-14 3.9-18.3 10.1C.7 22.8-.3 30.9 2.4 38.1c.1.4.5.7.9.7s.8-.3.9-.7c3-8.1 10.6-13.6 19.2-14v4.4c.1.4.3.8.7.9zM3.6 34.9C2.1 29 3.3 22.8 6.9 17.7c4.1-5.9 10.5-9.3 17.7-9.3.6 0 1-.4 1-1V4.1l14.3 11.2-14.4 11.2v-3.4c0-.6-.4-1-1-1-8.8 0-16.9 5.1-20.9 12.8zM63.5 27.9c-.1-.4-.5-.7-.9-.7s-.8.3-.9.7c-3 8.1-10.6 13.6-19.2 14v-4.4c0-.4-.2-.7-.6-.9-.3-.2-.8-.1-1.1.1L23.9 50c-.2.2-.4.5-.4.8s.1.6.4.8l16.9 13.3c.3.2.7.3 1.1.1.3-.2.6-.5.6-.9v-4.4c7.4-.3 14-3.9 18.3-10.1 4.4-6.5 5.4-14.5 2.7-21.7zm-4.4 20.4c-4.1 5.9-10.5 9.2-17.7 9.2-.6 0-1 .4-1 1v3.4L26.2 50.7l14.3-11.2v3.4c0 .6.4 1 1 1 8.9 0 17-5.1 20.9-12.8 1.4 5.9.3 12.2-3.3 17.2z"  opacity="1" data-original="#000000"></path></g></svg>
                    </div>
                    <button class="i-btn btn--lg btn--success update-btn" type="submit">One Click Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modal.delete_modal')
@endsection

@push('script-include')
   <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        $(".select2").select2({
            placeholder:"{{translate('Select Status')}}",
        })
        $(".select-priority").select2({
            placeholder:"{{translate('Select priority')}}",
        })

        $(".user").select2({
            placeholder:"{{translate('Select User')}}",
        })

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });

	})(jQuery);
</script>
@endpush
