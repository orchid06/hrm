@extends('admin.layouts.master')

@section('content')

@php
	$salarySettings     = !is_array(site_settings('salary_field',[])) ?  json_decode(site_settings('salary_field',[]),true) : [];
    $salaryType         = App\Enums\SalaryTypeEnum::toArray();
@endphp

<form action="{{route('admin.salary.store')}}"  method="POST" enctype="multipart/form-data">
    @csrf
    <div class="i-card-md">
        <div class="card--header">
            <div class="action">
                <button id="add-salary-option" class="i-btn btn--sm success">
                    <i class="las la-plus me-1"></i>   {{translate('Add More')}}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-12">
                    <input type="hidden" id="uid" name="uid" value="{{@$user->uid}}">
                    <div class="table-container">
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
                                        {{translate('Amount')}}
                                    </th>

                                    <th scope="col">
                                        {{translate('Action')}}
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="ticketField">
                                @foreach ($salarySettings as $input)
                                    <tr>
                                        <td data-label='{{translate("Label")}}'>
                                            <div class="form-inner mb-0">
                                                <input type="text" name="custom_inputs[{{$loop->index}}][labels]"  value="{{$input['labels']}}" required>
                                            </div>
                                        </td>
                                        <td data-label='{{translate("Type")}}'>
                                            <div class="form-inner mb-0">

                                                @if($input['default'] == App\Enums\StatusEnum::true->status())
                                                    <input disabled type="text" name="custom_inputs[type]"  value="Allowance">
                                                    <input type="hidden" name="custom_inputs[{{$loop->index}}][type]"  value="{{$input['type']}}">

                                                @else
                                                <select  class="form-select" name="custom_inputs[{{$loop->index}}][type]" required>
                                                    @foreach($salaryType as $type)
                                                        <option {{$input['type'] == $type ?'selected' :""}} value="{{$type}}">
                                                            {{ucfirst($type)}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @endif

                                            </div>
                                        </td>

                                        <td  data-label='{{translate("Amount")}}'>
                                            <div class="form-inner mb-0">
                                                <input type="text" name="custom_inputs[{{$loop->index}}][amount]"  value="{{$input['amount']}}" placeholder="{{translate('Enter amount')}}" required>
                                            </div>
                                            <input   type="hidden" name="custom_inputs[{{$loop->index}}][default]"  value="{{$input['default']}}">

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
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-20">
                        <button type="submit" class="i-btn ai-btn btn--md btn--primary" data-anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('script-push')
<script>
  "use strict";

        var count = "{{count($salarySettings)-1}}";
		// add more salary option
		$(document).on('click','#add-salary-option',function(e){
			count++
			var html = `<tr>
							<td data-label="{{translate("label")}}">
                                <div class="form-inner mb-0">
								  <input placeholder="{{translate("Enter Label")}}" type="text" name="custom_inputs[${count}][labels]" required>
                                </div>
							</td>

							<td data-label="{{translate("Type")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="custom_inputs[${count}][type]" required>
                                        <option value="1">Allowance</option>
                                        <option value="0">Deduction</option>
                                    </select>
                                </div>
							</td>
							<td data-label="{{translate("Amount")}}">
                                <div class="form-inner mb-0">
                                    <input placeholder="{{translate("Enter Amount")}}"  type="text" name="custom_inputs[${count}][amount]" required>
                                    <input  type="hidden" name="custom_inputs[${count}][default]"  value="0">
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
				$('#ticketField').append(html)

			e.preventDefault()
		})
        //delete ticket options
		$(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()
		})
</script>
@endpush

