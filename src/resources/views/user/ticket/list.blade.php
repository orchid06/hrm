@extends('layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div>
        <div class="i-card-md">
          <div class="card-header">
            <h4 class="card-title">
                {{translate(Arr::get($meta_data,'title'))}}
            </h4>

            <div class="d-flex align-items-center gap-2">
              <a   href="{{route('user.ticket.create')}}" class="i-btn primary btn--sm capsuled">
                <i class="bi bi-plus-lg"></i>
                 {{translate('Create Ticket')}}
              </a>
              <button class="icon-btn icon-btn-lg bg-info-solid text--light circle" type="button" data-bs-toggle="collapse" data-bs-target="#tableFilter"     aria-expanded="false"
                aria-controls="tableFilter">
                <i class="bi bi-funnel"></i>
              </button>
            </div>
          </div>

          <div class="collapse" id="tableFilter">
            <div class="search-action-area">
              <div class="search-area">
                <form action="{{ route(Route::currentRouteName()) }}" method="get">

                    <div class="form-inner">
                        <input type="text" id="datePicker" name="date" value="{{ request()->input('date') }}" placeholder="{{ translate('Filter by date') }}">
                    </div>

                    <div class="form-inner">
                        <input type="text" name="ticket_number" value="{{ request()->input('ticket_number') }}" placeholder="{{ translate('Enter Ticket Number') }}">
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

                    <div class="d-flex gap-2">
                        <button class="i-btn primary btn--lg rounded">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('user.ticket.list') }}" class="i-btn danger btn--lg rounded">
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
                                {{translate("Ticket Number")}}
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
                                        <a href="{{route('user.ticket.show',$ticket->ticket_number)}}">
                                            {{$ticket->ticket_number}}
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
                                            <a
                                                href="{{route('user.ticket.show',[$ticket->ticket_number])}}"
                                                class="icon-btn icon-btn-sm info">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            <a  href="javascript:void(0);" data-href="{{route('user.ticket.destroy',$ticket->id)}}" data-toggle="tooltip" data-placement="top" title="{{translate('Delete')}}"
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
            {{ $tickets->links() }}
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

        "use strict";

        $(".select2").select2({
            placeholder:"{{translate('Select Status')}}",
        })
        $(".select-priority").select2({
            placeholder:"{{translate('Select priority')}}",
        })


        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });


	})(jQuery);
</script>
@endpush

