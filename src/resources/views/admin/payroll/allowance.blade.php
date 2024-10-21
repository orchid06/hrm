@extends('admin.layouts.master')
@section('content')
@php
	$allowanceSettings     = !is_array(site_settings('allowance',[])) ?  json_decode(site_settings('allowance',[]),true) : [];
    $salaryType          = App\Enums\SalaryTypeEnum::toArray();
@endphp
<form data-route="{{route('admin.payroll.allowance.store')}}"  class="settingsForm" method="POST">
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

                            <tbody id="allowanceField">
                                @foreach ($allowanceSettings as $input)
                                    <tr>
                                        <td data-label='{{translate("Label")}}'>
                                            <div class="form-inner mb-0">
                                                <input type="text" name="custom_inputs[{{$loop->index}}][labels]"  value="{{$input['labels']}}" required>
                                            </div>
                                        </td>
                                        <td data-label='{{translate("Type")}}'>
                                            <div class="form-inner mb-0">


                                                <select  class="form-select" name="custom_inputs[{{$loop->index}}][type]" required>
                                                    @foreach($salaryType as $type => $value)
                                                        <option {{$input['type'] == $value ?'selected' :""}} value="{{$value}}">
                                                            {{ucfirst($type)}}
                                                        </option>
                                                    @endforeach
                                                </select>


                                            </div>
                                        </td>

                                        <td  data-label='{{translate("Amount")}}'>

                                            <div class="form-inner mb-0">

                                                    <div class="input-group">

                                                        <input placeholder="{{translate('Enter Amount')}}"  type="number" step="0.01" min="0" name="custom_inputs[{{$loop->index}}][amount]" value="{{$input['amount']}}" class="form-control" required>
                                                        <span class="input-group-text">
                                                            <select name="custom_inputs[{{$loop->index}}][is_percentage]" class="input-group-text" >
                                                                <option {{@$input['is_percentage'] == App\Enums\StatusEnum::false->status() ? 'selected' : ''}}  value={{App\Enums\StatusEnum::false->status()}}>{{(base_currency()->code)}}</option>
                                                                <option {{@$input['is_percentage'] == App\Enums\StatusEnum::true->status() ? 'selected' : ''}}  value={{App\Enums\StatusEnum::true->status()}}>%</option>
                                                            </select>
                                                        </span>
                                                    </div>

                                                <input   type="hidden" name="custom_inputs[{{$loop->index}}][default]"  value="{{$input['default']}}">
                                            </div>

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

@section('modal')
@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')

@endpush

@push('script-push')
<script>
    "use strict";

          var count = "{{count($allowanceSettings)-1}}";
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
                                      <div class="input-group">

                                          <input placeholder="{{translate('Enter Amount')}}"  type="number" min="0" name="custom_inputs[${count}][amount]" class="form-control" required>
                                          <span class="input-group-text">
                                              <select name="custom_inputs[${count}][is_percentage]" class="input-group-text">
                                                  <option value={{App\Enums\StatusEnum::false->status()}}>{{(base_currency()->code)}}</option>
                                                  <option value={{App\Enums\StatusEnum::true->status()}}>%</option>
                                              </select>
                                          </span>

                                          <input  type="hidden" name="custom_inputs[${count}][default]"  value="0">
                                      </div>
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
                  $('#allowanceField').append(html)

              e.preventDefault()
          })
          //delete ticket options
          $(document).on('click','.delete-option',function(e){
              $(this).closest("tr").remove()
              count--
              e.preventDefault()
          })

          $(".select2").select2({
                 placeholder:"{{translate('Select Item')}}",
               })
  </script>
@endpush
