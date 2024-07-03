@extends('layouts.master')
@push('style-include')
<link rel="stylesheet" href="{{ asset('assets/global/css/summnernote.css') }}">
@endpush
@section('content')

<div class="row g-4 mb-4">
    <div class="col-xl-9 col-lg-8">
        <div class="i-card-md">
            <div class="card-header">
                <h4 class="card-title">
                    {{translate(Arr::get($meta_data,'title'))}}
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
                    <form action="{{ route('user.ticket.reply') }}" class="give-replay" method="post">
                        @csrf
                        <input hidden value="{{ $ticket->id }}" type="text" name="id">
                        <textarea class="summernote" name="message" rows="3"
                            placeholder="{{ translate('Reply Here ....') }}"></textarea>
                        <div class="give-replay-action mt-4">
                            <div>
                                <button class="post-replay i-btn btn--primary btn--lg capsuled" type="submit">
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
                </div>

                <div class="discussion-continer mt-5">
                    <div class="i-card-md">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{ translate('Ticket Message') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="message-wrapper" data-simplebar>
                                @forelse($messages  as $message)
                                    @php
                                        $imgUrl = imageURL(@$ticket->user->file,"profile,user",true);
                                        if ($message->admin_id) {

                                            $imgUrl = imageURL($message->admin->file,"profile,admin",true);;
                                        }
                                    @endphp

                                        <div class="message-item d-flex justify-content-between align-items-start ticket-admin-reply">
                                            <div class="author-image me-2">
                                                <img class="rounded-circle avatar-sm" src="{{ $imgUrl }}" alt="profile.jpg" />
                                            </div>

                                            <div class="author-content flex-grow-1 ">
                                                <div class="mesg-meta mb-1">
                                                    <h6>
                                                        @if ($message->admin_id)
                                                            {{ $message->admin?->name }}
                                                        @else
                                                            {{ translate("Me") }}
                                                        @endif
                                                    </h6>
                                                    <small> {{ diff_for_humans($message->created_at) }}</small>
                                                </div>
                                                <div class="mesg-body">
                                                    @php echo $message->message  @endphp
                                                </div>
                                            </div>
                                        </div>
                                        <div class="meta">
                                            <h6>John Doe</h6>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <p>
                                            Information Technology (IT) revolutionizes industries by enhancing
                                            efficiency, fostering innovation, and connecting the world. It drives
                                            economic growth, empowers individuals, and transforms societies, shaping a
                                            future of limitless possibilities
                                        </p>
                                        <div class="message-time">
                                            <span>12.56 PM</span><i class="bi bi-check2-all"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="message-single message-right d-flex flex-column">
                                    <div
                                        class="user-area d-inline-flex justify-content-end align-items-center gap-3 mb-2">
                                        <div class="meta">
                                            <h6>John Doe</h6>
                                        </div>
                                        <div class="image">
                                            <img src="https://i.ibb.co/sbCZhQb/author3.jpg" alt="author3">
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <p>
                                            Information Technology (IT) revolutionizes industries by enhancing
                                            efficiency, fostering innovation, and connecting the world. It drives
                                            economic growth, empowers individuals, and transforms societies, shaping a
                                            future of limitless possibilities
                                        </p>
                                        <div class="message-time">
                                            <span>06.36 PM</span><i class="bi bi-check2-all"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="message-single message-left d-flex flex-column">
                                    <div class="user-area d-inline-flex align-items-center gap-3 mb-2">
                                        <div class="image">
                                            <img src="https://i.ibb.co/sbCZhQb/author3.jpg" alt="author3">
                                        </div>
                                        <div class="meta">
                                            <h6>John Doe</h6>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <p>
                                            Information Technology (IT) revolutionizes industries by enhancing
                                            efficiency, fostering innovation, and connecting the world. It drives
                                            economic growth, empowers individuals, and transforms societies, shaping a
                                            future of limitless possibilities
                                        </p>
                                        <div class="message-time">
                                            <span>02.07 PM</span><i class="bi bi-check2-all"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="message-single message-right d-flex flex-column">
                                    <div
                                        class="user-area d-inline-flex justify-content-end align-items-center gap-3 mb-2">
                                        <div class="meta">
                                            <h6>John Doe</h6>
                                        </div>
                                        <div class="image">
                                            <img src="https://i.ibb.co/sbCZhQb/author3.jpg" alt="author3">
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <p>
                                            Information Technology (IT) revolutionizes industries by enhancing
                                            efficiency, fostering innovation, and connecting the world. It drives
                                            economic growth, empowers individuals, and transforms societies, shaping a
                                            future of limitless possibilities
                                        </p>
                                        <div class="message-time">
                                            <span>06.36 PM</span><i class="bi bi-check2-all"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="message-single message-left d-flex flex-column">
                                    <div class="user-area d-inline-flex align-items-center gap-3 mb-2">
                                        <div class="image">
                                            <img src="https://i.ibb.co/sbCZhQb/author3.jpg" alt="author3">
                                        </div>
                                        <div class="meta">
                                            <h6>John Doe</h6>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <div class="message-file">
                                            <a href="#"><i class="bi bi-file-pdf"></i>instructions_all.pdf</a>
                                        </div>
                                        <div class="message-time">
                                            <span>11.04 AM</span><i class="bi bi-check2-all"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- New Chat start -->


                            <!-- New Chat end -->

                            <!-- <div class="message-wrapper" data-simplebar>
                                @forelse($messages as $message)
                                @php
                                $imgUrl = imageUrl(@$ticket->user->file,"profile,user",true);
                                if ($message->admin_id) {

                                $imgUrl = imageUrl($message->admin->file,"profile,admin",true);;
                                }
                                @endphp

                                <div
                                    class="message-item d-flex justify-content-between align-items-start ticket-admin-reply">
                                    <div class="author-image me-2">
                                        <img class="rounded-circle avatar-sm" src="{{ $imgUrl }}" alt="profile.jpg" />
                                    </div>

                                    <div class="author-content flex-grow-1 ">
                                        <div class="mesg-meta mb-1">
                                            <h6>
                                                @if ($message->admin_id)
                                                {{ $message->admin?->name }}
                                                @else
                                                {{ translate("Me") }}
                                                @endif
                                            </h6>
                                            <small> {{ diff_for_humans($message->created_at) }}</small>
                                        </div>
                                        <div class="mesg-body">
                                            @php echo $message->message @endphp
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @include('admin.partials.not_found')
                                @endforelse

                                <div
                                    class="message-item d-flex justify-content-between align-items-start ticket-admin-reply">
                                    <div class="author-image me-2">
                                        <img class="rounded-circle avatar-sm" src="{{ $imgUrl }}" alt="profile.jpg" />
                                    </div>

                                    <div class="author-content flex-grow-1 ">
                                        <div class="mesg-meta mb-1">
                                            <h6>
                                                @if ($message->admin_id)
                                                {{ $message->admin?->name }}
                                                @else
                                                {{ translate("Me") }}
                                                @endif
                                            </h6>
                                            <small> {{ diff_for_humans($message->created_at) }}</small>
                                        </div>
                                        <div class="mesg-body">
                                            @php echo $message->message @endphp
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-4">
        <div class="i-card-md">
            <div class="card-header">
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
                                    @php echo ticket_status($ticket->status) @endphp
                                </td>
                            </tr>

                            <tr>
                                <td>{{ translate('Priority') }} :</td>
                                <td>
                                    @php echo priority_status($ticket->priority) @endphp
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="i-card-md mt-4">
            <div class="card-header">
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



        @if ($files && $files->count() > 0)
        <div class="i-card-md mt-4">
            <div class="card-header">
                <h4 class="card-title">
                    {{ translate('Files') }}
                </h4>
            </div>

            <div class="card-body">
                <div class="ticket-attach">
                    @foreach ($files as $file)
                    <form action="{{ route('user.ticket.file.download') }}" method="post">
                        <input hidden type="text" name="id" value="{{ $file->id }}">

                        @csrf
                        <div class="attach-item d-flex gap-4 justify-content-between align-items-center">
                            <h6 class="file-info">
                                {{ translate('File-') . $loop->index + 1 }}
                            </h6>

                            <div class="d-flex gap-2">
                                <button type="submit" class="icon-btn icon-btn-md info circle download-btn"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title=" {{ translate('Download')}}">
                                    <i class="bi bi-download"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>




@endsection

@push('script-include')
<script src="{{ asset('assets/global/js/summernote.min.js') }}"></script>
<script src="{{ asset('assets/global/js/editor.init.js') }}"></script>
@endpush