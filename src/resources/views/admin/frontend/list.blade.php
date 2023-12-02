@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/summnernote.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
@endpush
@section('content')

    <div class="i-card-md">

        <div class="card-body">

            @if(@$appearance->content)
                @include('admin.frontend.partial.content')
            @endif

            @if(@$appearance->element)
               @include('admin.frontend.partial.element')
            @endif

        </div>

    </div>

@endsection


@section('modal')
    @include('modal.delete_modal')

    @if(@$appearance->element)

        <div class="modal fade" id="sectionSave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sectionSave"   aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{translate('Save '.k2t(request()->route("key"))." Item")}}
                        </h5>
                        <button class="close-btn" data-bs-dismiss="modal">
                            <i class="las la-times"></i>
                        </button>
                    </div>

                    <form action="{{route('admin.appearance.update')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="id">
                                <input type="hidden" name="type" value="element">
                                <input type="hidden" name="key" value="{{request()->route("key")}}">

                                @foreach($appearance->element as $k => $content)
                                    @if($k != 'modal')
                                        @if($k == 'images')
                                            @foreach($content as $imK => $imV)
                                        
                                                <div class="col-lg-12">
                                                    <div class="form-inner">
                                                        <label for="{{$imK}}">
                                                            {{translate(k2t($imK))}} <small class="text-danger">({{@$imV->size}})</small>
                                                        </label> 

                                                        <input   data-size = "100x100" id="{{$imK}}" name="image_input[{{ $imK }}]" type="file" class=" preview" >
                
                                                        <div class="mt-2 image-preview-section modal-file-{{$loop->index}}">

                                                        </div>                      
                                                                        
                                                    </div>
                                                </div>

                                            @endforeach
                                        @elseif($k == 'select')

                                            @foreach($content as $k => $v)
                                        
                                                    <div class="col-lg-12">
                                                        <div class="form-inner">
                                                            <label for="{{$k}}">
                                                                {{translate(k2t($k))}} 
                                                            </label>

                                                            <select name="select_input[{{$k}}]" id="{{$k}}">
                                                                <option value="">{{translate("Select Option")}}</option>
                                                                @foreach (explode(',',$v) as  $val)

                                                                    <option {{@$appearance_content->value->select_input->{$k} == $val? "selected" :""}}  value="{{$val}}">
                                                                        {{$val}}
                                                                    </option>
                                                                    
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                            @endforeach

                                        @else
                                     
                                            <div class="col-lg-12">
                                                <div class="form-inner">

                                                    <label for="{{$k}}">
                                                        {{translate(k2t($k))}} <small class="text-danger">*</small>
                                                    </label> 

                                                    @if($content == 'textarea' || $content == 'textarea-editor')
                                                    
                                                            <textarea  placeholder="{{translate(k2t($k))}}"   @if($content == 'textarea-editor') class="summernote"  @endif name="{{$k}}" id="{{$k}}" cols="30" rows="10"></textarea>
                                                    @else

                                                            <input value="{{@$appearance_content->value->$k}}" placeholder="{{translate(k2t($k))}}" @if($content  == 'icon' ) class="icon-picker icon"  autocomplete="off" @endif type="{{$content == 'number' ? "number" :"text"}}" name="{{$k}}" id="{{$k}}">
                                                    
                                                    @endif
                                                </div>

                                            </div>

                                        @endif
                                    @endif
                                @endforeach

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--md ripple-dark" anim="ripple" data-bs-dismiss="modal">
                                {{translate("Close")}}
                            </button>
                            <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                {{translate("Submit")}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


@endsection




@push('script-include')

    <script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
    <script src="{{asset('assets/global/js/editor.init.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrapicon-iconpicker.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){
       	"use strict";
            $(".select2").select2({
			   placeholder:"{{translate('Select Status')}}",
	     	})

             $(document).on('click','.create',function(e){

                var modal = $('#sectionSave');
                var form = modal.find('form');
                modal.find('input[name="id"]').attr('disabled',true);
                form[0].reset();
                $('.image-preview-section').html('')
                modal.modal('show');

             });

             $(document).on('click','.update',function(e){

                  var modal        = $('#sectionSave');
                  var form = modal.find('form');
                  form[0].reset();
                  var files        = JSON.parse($(this).attr('data-files'));
                  var appearances  =  JSON.parse($(this).attr('data-appearance'));

                  modal.find('input[name="id"]').attr('disabled',false);
                  modal.find('input[name=id]').val($(this).attr('data-id'));

                  if(appearances != null){
   
                        for(let i in appearances){
                            if(i !=  'select_input'){
                                var $element = modal.find(`[name=${i}]`);
              
                                if ($element.hasClass("summernote") ) {
                                        $($element).summernote('destroy');
                                        $($element).html(appearances[i]);

                                        $($element).summernote({
                                                height: 300,
                                                placeholder: 'Start typing...',
                                                toolbar: [
                                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                                ['height', ['height']],
                                                ['insert', ['picture', 'link', 'video']],
                                                ['view', ['codeview']],
                                                ],
                                               
                                        });

                                } else {
                           
                                    $element.val(appearances[i]);
                                }
                            }
                            else{
                                for(let j in appearances[i]){
                                    var $select = modal.find(`[name='select_input[${j}]']`);
                                    var valueToSelect = appearances[i][j];
                                    $select.find('option').each(function () {
                                        if ($(this).val() === valueToSelect) {
                                            $(this).prop('selected', true);
                                        }
                                    });
                                }
                            }
                     
                        }
                  }
             
                  if (Array.isArray(files)) {
                      for(var i   =  0 ; i < files.length ; i++ ){
                         var img = `<img  style="width:100px;height:100px;"  src="${files[i]}" >`;

                         $(`.modal-file-${i}`).html(img)
                      }
                  }

                  modal.modal('show');


             });


      
            $('.icon-picker').iconpicker({
               title: "{{translate('Search Here !!')}}",
            });


            $(document).on('click','.section-search-btn',function(){

                   $('.table-loader').removeClass("d-none");
                    var searchTerm = $('.section-search').val().toUpperCase();
                    var searchResults = $(".custom-tbody tr").filter(function (idx, elem) {
                        return $(elem).text().trim().toUpperCase().indexOf(searchTerm) >= 0 ? elem : null;
                    }).sort();
                    var table = $('.custom-tbody');
                    if (searchResults.length == 0) {
                         table.html('<tr><td colspan="100" class="text-center">{{translate("No data found!!")}}</td></tr>');
                    }else{
                        table.html(searchResults);
                    }

                    setTimeout(function() { 
                        $('.table-loader').addClass("d-none");
                    }, 1000);
                   
            });





	})(jQuery);
</script>
@endpush


