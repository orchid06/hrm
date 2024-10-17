@extends('admin.layouts.master')
@section('content')
@php
    $customInputs = json_decode($leave_type->custom_inputs , true);
@endphp
<div class="i-card-md mb-4">
    <div class="card--header">
        <h4 class="card-title">
            {{ translate('Edit Leave Types') }}
        </h4>
    </div>

        <div class="card-body">
            <form data-route="{{route('admin.leave_type.update')}}"  class="settingsForm" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{$leave_type->id}}">
                <div class="mb-5">
                    <div class="mt-10">
                        <div class="row">

                            <!-- Default Clock-in Status Dropdown -->
                            <div class="col-xl-6">
                                <div class="form-inner">
                                    <label for="name">{{translate('Name')}} <small class="text-danger">*</small></label>
                                    <input type="text" name="name" id="name" value="{{$leave_type->name}}" required>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-inner">
                                    <label for="days">{{translate('Allowed Days')}} </label>
                                    <i class="las la-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('These are yearly allowed leave days.')}}"></i>
                                    <input type="number" name="days" id="days" value="{{$leave_type->days}}">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-inner">
                                    <label for="is_paid_add">{{translate('Paid/Unpaid')}}<small
                                            class="text-danger">*</small></label>
                                    <select class="select2" name="is_paid" id="is_paid_add" placeholder="{{translate('Select Type')}}" required>
                                        <option value="">{{translate('Select a type')}}</option>
                                        @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                                        <option {{$leave_type->is_paid == $value ? "selected" :"" }} value="{{$value}}">
                                            {{$value == App\Enums\StatusEnum::true->status()? 'Paid' : 'Unpaid'}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-inner">
                                    <label for="status_add">{{translate('Status')}}<small class="text-danger">*</small></label>
                                    <select class="select2" name="status" id="status_add" placeholder="{{translate('Select Status')}}" required>

                                        @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                                        <option {{$leave_type->status==$value ? "selected" :"" }} value="{{$value}}">
                                            {{$status}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content">
                                <button id="add-custom-field"  class="add i-btn btn--sm success">
                                    <i class="las la-plus me-1"></i> {{translate('Add Custom Field')}}
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="table-container mt-4 d-none">
                        <table class="align-middle">
                            <thead class="table-light ">
                                <tr>
                                    <th scope="col">
                                        {{translate('Labels')}}
                                    </th>

                                    <th scope="col">
                                        {{translate('Type')}}
                                    </th>
                                    <th scope="col">
                                        {{translate('Mandatory/Required')}}
                                    </th>

                                    <th scope="col">
                                        {{translate('Placeholder')}}
                                    </th>

                                    <th scope="col">
                                        {{translate('Action')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="customField">
                                @if (!empty($customInputs))
                                    @foreach ($customInputs as $input)
                                        <tr>
                                            <td data-label='{{translate("Label")}}'>
                                                <div class="form-inner mb-0">
                                                    <input type="text" name="custom_inputs[{{$loop->index}}][labels]"  value="{{$input['labels']}}">
                                                </div>
                                            </td>
                                            <td data-label='{{translate("Type")}}'>
                                                <div class="form-inner mb-0">

                                                    @if($input['default'] == App\Enums\StatusEnum::true->status())
                                                        <input disabled type="text" name="custom_inputs[type]"  value="{{$input['type']}}">
                                                        <input type="hidden" name="custom_inputs[{{$loop->index}}][type]"  value="{{$input['type']}}">
                                                    @else
                                                    <select  class="form-select" name="custom_inputs[{{$loop->index}}][type]" >
                                                        @foreach(['file','textarea','text','date','email'] as $type)
                                                            <option {{$input['type'] == $type ?'selected' :""}} value="{{$type}}">
                                                                {{ucfirst($type)}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @endif

                                                </div>
                                            </td>
                                            <td  data-label='{{translate("Required")}}' >
                                                <div class="form-inner mb-0">
                                                    @if($input['default'] == App\Enums\StatusEnum::true->status() && $input['type'] != 'file' )
                                                        <input disabled  type="text" name="custom_inputs[required]"  value="{{$input['required'] == App\Enums\StatusEnum::true->status()? 'Yes' :'No'}}">
                                                        <input hidden  type="text" name="custom_inputs[{{$loop->index}}][required]"  value="{{$input['required']}}">
                                                    @else
                                                        <select class="form-select" name="custom_inputs[{{$loop->index}}][required]" >
                                                            <option {{$input['required'] == App\Enums\StatusEnum::true->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                                {{translate('Yes')}}
                                                            </option>
                                                            <option {{$input['required'] == App\Enums\StatusEnum::false->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                                {{translate('No')}}
                                                            </option>
                                                        </select>
                                                    @endif
                                                </div>
                                            </td>
                                            <td  data-label='{{translate("Placeholder")}}'>
                                                <div class="form-inner mb-0">
                                                    <input type="text" name="custom_inputs[{{$loop->index}}][placeholder]"  value="{{$input['placeholder']}}">
                                                </div>
                                                <input   type="hidden" name="custom_inputs[{{$loop->index}}][default]"  value="{{$input['default']}}">
                                                <input   type="hidden" name="custom_inputs[{{$loop->index}}][multiple]"  value="{{$input['multiple']}}">
                                                <input   type="hidden" name="custom_inputs[{{$loop->index}}][name]"  value="{{$input['name']}}">
                                            </td>
                                            <td data-label='{{translate("Option")}}'>
                                                @if($input['default'] == App\Enums\StatusEnum::true->status())
                                                    {{translate('N/A')}}
                                                    @else
                                                    <div>
                                                        <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                                            <i class="las la-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                     <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="i-btn ai-btn btn--md btn--primary" data-anim="ripple">
                            {{ translate('Submit') }}
                        </button>
                    </div>
                </div>


            </form>
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
    (function ($) {
    "use strict";

    $('.select2').select2({
        placeholder: $(this).attr('placeholder'),
    });

    })(jQuery);

    if ($("#customField tr").length > 0) {
        $('.table-container').removeClass('d-none');
    }


    var count = 0;
		// add more kyc option
		$(document).on('click','#add-custom-field',function(e){
            $('.table-container').removeClass('d-none');

			count++
			var html = `<tr>
							<td data-label="{{translate("label")}}">
                                <div class="form-inner mb-0">
								  <input placeholder="{{translate("Enter Label")}}" type="text" name="custom_inputs[${count}][labels]" >
                                </div>
							</td>

							<td data-label="{{translate("Type")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="custom_inputs[${count}][type]" >
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="date">Date</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="file">File</option>
                                    </select>
                                </div>
							</td>
							<td data-label="{{translate("Required")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="custom_inputs[${count}][required]" >
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
							</td>
							<td data-label="{{translate("placeholder")}}">
                                <div class="form-inner mb-0">
                                    <input placeholder="{{translate("Enter Placeholder")}}"  type="text" name="custom_inputs[${count}][placeholder]" >
                                    <input  type="hidden" name="custom_inputs[${count}][default]"  value="0">
                                    <input  type="hidden" name="custom_inputs[${count}][multiple]"  value="0">
                                    <input  type="hidden" name="custom_inputs[${count}][name]"  value="">
                                </div>
							</td>
							<td data-label='{{translate("Option")}}'>
							   <div >
                                    <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                         <i class="las la-trash-alt"></i>
                                    </a>
                                </div>
							</td>

						</tr>`;
				$('#customField').append(html)

			e.preventDefault()
		})
        //delete ticket options
		$(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()

            if ($("#customField tr").length === 0) {
                // If no rows are left, add the d-none class to the table container
                $('.table-container').addClass('d-none');
            }
		})
</script>
@endpush
