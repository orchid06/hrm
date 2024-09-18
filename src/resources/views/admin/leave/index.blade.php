@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <div class="col-md-4 d-flex justify-content-start">
                    <div class="action">
                        <a href="{{route('admin.leave_type.list')}}" type="button" class="i-btn btn--sm primary">
                            <i class="las la-cogs fs-15"></i>  {{translate('Configure Leave Type')}}
                        </a>
                    </div>
                </div>

                <div class="col-md-8 d-flex justify-content-md-end justify-content-start">

                    <div class="search-area">


                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                <select name="month" class="select2" id="month" placeholder="{{translate('Select a month')}}">
                                    <option value="">{{translate('Month')}}</option>
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' :'' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <select name="year" class="select2" id="year" placeholder="{{translate('Select a year')}}">
                                    <option value="">{{translate('Select a Year')}}</option>
                                    @foreach(range(date('Y') - 5, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : ''}}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="date-search">
                                <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"
                                    placeholder="{{translate('Filter by date')}}">
                                <button type="submit" class="me-2"><i class="bi bi-search"></i></button>

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
                            {{translate('Type')}}
                        </th>

                        <th scope="col">
                            {{translate('Reason')}}
                        </th>

                        <th scope="col">
                            {{translate('Start Date')}}
                        </th>

                        <th scope="col">
                            {{translate('End Date')}}
                        </th>

                        <th scope="col">
                            {{translate('Days')}}
                        </th>

                        <th scope="col">
                            {{translate('Note')}}
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)

                    <tr>

                        <td data-label="{{translate('Type')}}">
                            {{$leave->leaveType->name}}
                        </td>

                        <td data-label="{{translate('Reason')}}">
                            {{$leave->reason}}
                        </td>

                        <td data-label="{{translate('Start Date')}}">
                            {{ \Carbon\Carbon::parse($leave->start_date)->format('j M, Y') }}
                        </td>

                        <td data-label="{{translate('End Date')}}">
                            {{ \Carbon\Carbon::parse($leave->end_date)->format('j M, Y') }}
                        </td>

                        <td data-label="{{translate('Total Days')}}">
                           {{$leave->total_days}}
                        </td>

                        <td data-label="{{translate('Status')}}">
                            @php
                                $status = $statusClasses[$leave->status] ?? ['class' => 'secondary', 'text' => translate('Unknown')];
                            @endphp

                            <span class="i-badge capsuled {{ $status['class'] }}">{{ $status['text'] }}</span>
                        </td>


                        <td data-label="{{translate('Note')}}">
                            <div class="table-action">

                                <button data-bs-toggle="tooltip" data-bs-placement="top" leave="{{$leave}}"
                                data-bs-title="{{translate('View note')}}" class="note icon-btn info">
                                <i class="las la-eye"></i>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="border-bottom-0" colspan="8">
                            @include('admin.partials.not_found')
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $leaves->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')
@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')

@endpush

@push('script-push')
<script>
    "use strict"
   $('.select2').each(function () {
       $(this).select2({
           placeholder: $(this).attr('placeholder')
       });
   });

   $('.note').on('click', function() {
       var attendance = JSON.parse($(this).attr("leave"));
       var modal = $('#noteModal')

       modal.find('input[name="attendance_id"]').val(leave.id)
       modal.find('textarea[name="note"]').val(leave.note)
       modal.modal('show');
   });
</script>
@endpush
