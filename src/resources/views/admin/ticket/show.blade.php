@extends('admin.layouts.master')

@push('style-include')
   <link rel="stylesheet" href="{{ asset('assets/global/css/summnernote.css') }}">
@endpush

@section('content')
    <div class="row g-3 mb-3">
        <div class="col-xl-9 col-lg-8">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Reply Ticket') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="ticket-conversation">
                            @if ($ticket->status == App\Enums\TicketStatus::CLOSED->value)
                                <div class="text-center">
                                    <p class="text-danger fs-2">
                                        {{ translate('Ticket Closed') }}
                                    </p>
                                </div>
                            @else
                            <form action="{{ route('admin.ticket.reply') }}" class="give-replay" method="post">
                                @csrf
                                <input hidden value="{{ $ticket->id }}" type="text" name="id" >
                                <textarea class="summernote" name="message" rows="3" placeholder="{{ translate('Reply Here ....') }}">
                              </textarea>
                                <div class="give-replay-action">
                                    <div>
                                        <button class="post-replay i-btn btn--sm btn--primary" type="submit">
                                            {{ translate('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        @php
                            $messages = $ticket->messages;
                            $files = $ticket->file;
                        @endphp
                        <div class="discussion-continer">
                            <div class="i-card-md">
                                <div class="card--header px-0">
                                    <h4 class="card-title">
                                        {{ translate('Ticket Message') }}
                                    </h4>
                                </div>
                                <div class="card-body px-0 pb-0">
                                    @forelse($messages    as $message)
                                        @php
                                            $imgUrl = imageUrl(@$ticket->user->file,"profile,user",true);
                                            if ($message->admin_id) {
                   
                                                $imgUrl = imageUrl($message->admin->file,"profile,admin",true);;
                                            }
                                        @endphp
                                        <div class="message-item d-flex justify-content-between align-items-start">
                                            <div class="d-flex flex-grow-1">
                                                <div class="author-image me-3">
                                                    <img class="rounded-circle avatar-sm" src="{{ $imgUrl }}" alt="profile.jpg" />
                                                </div>
                                                <div class="author-content flex-grow-1">
                                                    <div class="mesg-meta mb-1">
                                                        <h6>
                                                            @if ($message->admin_id)
                                                                {{ $message->admin?->name }}
                                                            @else
                                                                {{ $ticket->user?->name }}
                                                            @endif
                                                        </h6>
                                                        <small> {{ diff_for_humans($message->created_at) }}</small>
                                                    </div>
                                                    <div class="mesg-body">
                                                        @php echo $message->message  @endphp
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mesg-action">
                                                <div class="i-dropdown">
                                                    <a href="javascript:void(0)" class="icon-btn info p-2" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        data-popper-placement="bottom-end">
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                data-href="{{ route('admin.ticket.destroy.message',$message->id) }}"
                                                                class="delete-item  dropdown-item" type="button">
                                                                <i class="bi bi-trash3 me-2"></i>
                                                                {{ translate('Delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        @include('admin.partials.not_found')
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4">
            <div class="i-card-md mb-30">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Ticket Details') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="ticket-dtable">
                        <table>
                            <tbody>
                                <tr>
                                    <td>{{ translate('Ticket Id') }} :</td>
                                    <td>
                                        {{ $ticket->ticket_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ translate('Subject') }} :</td>
                                    <td>
                                        {{ $ticket->subject }}
                                    </td>
                                </tr>
                                <tr>
                                    <td> {{ translate('Creation Time') }} :</td>
                                    <td id="c-date"> {{ get_date_time($ticket->created_at) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ translate('Status') }} :</td>
                                    <td>
                                        <select name="status" class="niceSelect w-100 update-status">
                                            @foreach (App\Enums\TicketStatus::toArray() as $k => $v)
                                                <option {{ $ticket->status == $v ? 'selected' : '' }}
                                                    value="{{ $v }}">
                                                    {{ ucfirst(strtolower($k)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ translate('Priority') }} :</td>
                                    <td>
                                        <select name="priority" class="niceSelect w-100  update-status">
                                            @foreach (App\Enums\PriorityStatus::toArray() as $k => $v)
                                                <option {{ $ticket->priority == $v ? 'selected' : '' }}
                                                    value="{{ $v }}">
                                                    {{ ucfirst(strtolower($k)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="i-card-md mb-30">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Custom Data') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="ticket-dtable">
                        <table>
                            <tbody>
                                @forelse($ticket->ticket_data as $k => $v)
                                    @if ($k != 'description')
                                        <tr>
                                            <td>{{ ucfirst($k) }} :</td>
                                            <td>
                                                {{ $v }}
                                            </td>
                                        </tr>
                                    @endif
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
            @if ($files && $files->count()  > 0)
                <div class="i-card-md mb-30">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{ translate('Files') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @foreach ($files as $file)
                            <form action="{{ route('admin.ticket.file.download') }}" method="post">
                                <input hidden type="text" name="id" value="{{ $file->id }}">
                                @csrf
                                <div class="attach-item d-flex gap-4 justify-content-between align-items-center  mb-3">
                                    <div class="file-info">
                                        {{ translate('File-') . $loop->index + 1 }}
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="download-btn">
                                            <i class="las la-download"></i>

                                            <span class="tooltip">
                                                {{ translate('Download') }}
                                            </span>
                                        </button>
                                        <a href="javascript:void(0);"
                                            data-href="{{route('admin.ticket.destroy.file',$file->id)}}"
                                            class="pointer download-btn delete-item icon-btn danger">
                                            <i class="las la-trash-alt"></i>
                                            <span class="tooltip">
                                                {{ translate('Delete') }}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <form id="statusUpdate" action="{{ route('admin.ticket.update') }}" method="post">
        @csrf
        <input hidden name="id" value="{{ $ticket->id }}" type="text">
        <input hidden name="key" value="" id="key" type="text">
        <input hidden name="status" value="status" id="inputStatus" type="text">
    </form>

@endsection

@section('modal')

    @include('modal.delete_modal')
  
@endsection

@push('script-include')
    <script src="{{ asset('assets/global/js/summernote.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/editor.init.js') }}"></script>
@endpush

@push('script-push')
    <script>
        (function($) {

            $(".select2").select2({
                placeholder: "{{ translate('Select Status') }}",
            })
            $(document).on('change', '.update-status', function(e) {
                var val = $(this).val()
                var key = $(this).attr('name')
                $("#key").val(key)
                $("#inputStatus").val(val)
                $('#statusUpdate').submit()
            })

        })(jQuery);
    </script>
@endpush
