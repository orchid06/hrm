@extends('admin.layouts.master')
@section('content')

<div class="i-card-md mb-4">
    <div class="card--header">
        <h4 class="card-title">
            {{ translate('Account creation form') }}
        </h4>
    </div>

        <div class="card-body">
            <form action="{{route('admin.account.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <div class="mt-10">
                        <div class="row">

                            <!-- Default Clock-in Status Dropdown -->
                            <div class="col-xl-6">
                                <div class="form-inner">
                                    <label for="name">{{translate('Name')}} <small class="text-danger">*</small></label>
                                    <input type="text" name="name" id="name"  required>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-inner">
                                    <label for="balance">{{translate('Balance')}} </label>
                                    <i class="las la-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Initial Balance for this account')}}"></i>
                                    <input type="number" name="balance" id="balance" >
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
                                        {{translate('Key')}}
                                    </th>

                                    <th scope="col">
                                        {{translate('Value')}}
                                    </th>

                                    <th scope="col">
                                        {{translate("Attachment")}}
                                    </th>

                                    <th scope="col">
                                        {{translate('Action')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="customField">

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



    })(jQuery);


    var count = 0;
		// add more kyc option
		$(document).on('click','#add-custom-field',function(e){
            $('.table-container').removeClass('d-none');

			count++
			var html = `<tr>
							<td data-label="{{translate("label")}}">
                                <div class="form-inner mb-0">
								  <input  type="text" name="custom_inputs[${count}][key]" placeholder="{{translate("Enter Key")}}">
                                </div>
							</td>


							<td data-label="{{translate("Value")}}">
                                <div class="form-inner mb-0">
                                    <input   type="text" name="custom_inputs[${count}][value]" placeholder="{{translate("Enter Value")}}">
                                </div>
							</td>

                            <td data-label="{{translate("Value")}}">
                                <div class="form-inner mb-0">
                                    <input   type="file" name="custom_inputs[${count}][file]" placeholder="{{translate("Upload File")}}">
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
