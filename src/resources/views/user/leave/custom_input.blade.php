@extends('layouts.master')

@push('style-include')
@endpush

@section('content')
@php
     $customInputs          = json_decode($leave->leaveType->custom_inputs , true);
@endphp
<div class="i-card-md">

    <div class="card--header">
        <a href="{{route('user.leave.request.edit' , $leave->id)}}">
            <button class="i-btn btn--md btn--primary" data-anim="ripple">
                <i class="las la-arrow-left"> {{translate('Back')}}</i>
            </button>
        </a>
    </div>

    <div class="card-body">

        <div class="alert alert-info p-2">
            {{ translate('Please fill up this form to complete your leave request') }}
        </div>
        <form action="{{route('user.leave.request.customInput.store')}}" method="post" enctype="multipart/form-data">
            @csrf
           <input type="hidden" name="id" value="{{$leave->id}}">

           <div class="row">
               @foreach($customInputs as $customInput)
                   @php
                       if(isset($customInput['name']))           $field_name = $customInput['name'];
                   @endphp
                   <div class="col-lg-{{$customInput['type'] == 'textarea'  ? 12 :6}}">

                           <div class="form-inner">
                               <label for="{{$loop->index}}" class="form-label">
                                   {{$customInput['labels']}} @if($customInput['required'] == '1' || $customInput['type'] == 'file') <span class="text-danger">
                                       {{$customInput['required'] == '1' ?  "*" :""}}

                                   </span>@endif
                               </label>

                               @if($customInput['type'] == 'textarea')
                               <textarea id="{{$loop->index}}" {{$customInput['required'] == '1' ? "required" :""}} class="summernote"  name="leave_request_data[{{ $field_name }}]" cols="30" rows="10" placeholder="{{$customInput['placeholder']}}">{{old('leave_request_data.'.$field_name)}}</textarea>
                               @elseif($customInput['type'] == 'file')
                                   <input id="{{$loop->index}}"  {{$customInput['required'] == '1' ? "required" :""}}     type="file" name="leave_request_data[files][{{$field_name}}]" >
                               @else
                                   <input id="{{$loop->index}}" {{$customInput['required'] == '1' ? "required" :""}} type="{{$customInput['type']}}"   name="leave_request_data[{{ $field_name }}]" value="{{old('leave_request_data.'.$field_name)}}"  placeholder="{{$customInput['placeholder']}}">
                               @endif
                           </div>
                   </div>
               @endforeach

               <div class="d-flex justify-content-end mt-3">

                   <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                       {{translate("Submit")}}
                   </button>
               </div>

           </div>
       </form>

    </div>
</div>
@endsection

@push('script-include')
@endpush

@push('script-push')
@endpush
