@extends('layouts.master')

@push('style-include')
@endpush

@section('content')

<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <form action="{{route('user.leave.request')}}" method="POST" enctype="multipart/form-data">
            @csrf

                <div class="row">
                    <div class="col-12">
                        <div class="form-inner">
                            <label for="leave_type_id">{{translate('Leave Type')}} <small
                                    class="text-danger">*</small></label>
                            <select name="leave_type_id" id="leave_type_id" class="select2" required>
                                <option value="">{{translate('Select Leave Type')}}</option>
                                @foreach($leaveTypes as $leaveType);

                                <option value="{{ $leaveType->id }}">
                                    {{ $leaveType->name }}
                                    ({{ $leaveType->is_paid == \App\Enums\StatusEnum::true->status() ?
                                    translate('Paid') : translate('Unpaid') }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="leave_duration_type">{{translate('Leave Duration Type')}} <small
                                class="text-danger">*</small></label>
                        <select class="select2" id="leave_duration_type" name="leave_duration_type" required>
                            <option value="">{{translate('Select Duration Type')}}</option>
                            @foreach(\App\Enums\LeaveDurationType::toArray() as $duration)
                            <option value="{{ $duration }}">{{ $duration }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div id="single_date_picker">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-inner">
                                <label for="date">{{translate('Date')}} </label>
                                <input type="date" name="date" id="date" class="form-control"
                                    placeholder="{{translate('Select Date')}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="range_date_picker" class="d-none">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-inner">
                                <label for="start_date">{{translate('Start Date')}}</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    placeholder="{{translate('Start Date')}}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-inner">
                                <label for="end_date">{{translate('End Date')}}</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    placeholder="{{translate('End Date')}}">
                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-inner">
                    <label for="reason">{{translate('Reason')}}</label>
                    <textarea name="reason" id="reason" cols="30" rows="10"> </textarea>
                </div>

                <div class="form-inner">
                    <label for="attachments">{{translate('Attachments')}}</label>
                    <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                </div>


                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Submit")}}
                    </button>
                </div>
        </form>
    </div>
</div>
@endsection

@push('script-include')
@endpush

@push('script-push')
<script>
    "use strict";

    (function ($) {

        $('.select2').select2({
            placeholder: $(this).attr('placeholder'),
        });

    })(jQuery);

    $('#leave_duration_type').on('change', function () {
        if ($(this).val() === 'Range') {
            $('#date').val('');
            $('#single_date_picker').addClass('d-none');
            $('#range_date_picker').removeClass('d-none');

        } else {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#single_date_picker').removeClass('d-none');
            $('#range_date_picker').addClass('d-none');
        }
    });

    // $('#leave_type_id').on('change', function () {
    //     var id          = $(this).val();
    //     var leaveTypes  = @json($leaveTypes);
    //     var selectedLeaveType = leaveTypes.find(function(type) {
    //         return type.id == id;
    //     });

    //     if (selectedLeaveType) {
    //         if (selectedLeaveType.custom_inputs) {
    //             try {
    //                 var customInputs = JSON.parse(selectedLeaveType.custom_inputs);

    //                 generateCustomInputs(customInputs);

    //             } catch (error) {
    //                 console.error('Error decoding custom inputs:', error);
    //             }
    //         }
    //     }

    // });

    // function generateCustomInputs(customInputs) {

    // var container = $('#custom-inputs-container');

    // // Clear existing inputs (if any)
    // container.empty();

    // // Iterate over each custom input field
    // customInputs.forEach(function(input, index) {
    //     var fieldHtml = ''; // Initialize the HTML for the input field

    //     // Check if the input has a 'name' and other required properties
    //     if (input.name) {
    //         var field_name = input.name;
    //         var required = input.required == '1' ? 'required' : '';
    //         var placeholder = input.placeholder || '';
    //         var label = input.labels || 'Field ' + (index + 1);
    //         var isRequiredStar = input.required == '1' ? '*' : '';

    //         // Create label HTML
    //         fieldHtml += '<div class="form-inner">';
    //         fieldHtml += `<label for="${index}" class="form-label">${label} ${isRequiredStar ? '<span class="text-danger">*</span>' : ''}</label>`;

    //         // Check field type and generate appropriate input field
    //         if (input.type == 'textarea') {
    //             fieldHtml += `<textarea id="${index}" ${required} class="summernote" name="kyc_data[${field_name}]" cols="30" rows="10" placeholder="${placeholder}"></textarea>`;
    //         } else if (input.type == 'file') {
    //             fieldHtml += `<input id="${index}" ${required} type="file" name="kyc_data[files][${field_name}]">`;
    //         } else {
    //             fieldHtml += `<input id="${index}" ${required} type="${input.type}" name="kyc_data[${field_name}]" placeholder="${placeholder}">`;
    //         }

    //         // Close the form-inner div
    //         fieldHtml += '</div>';
    //     }

    //     // Append the generated HTML to the container
    //     container.append(fieldHtml);
    // });
}



</script>
@endpush
