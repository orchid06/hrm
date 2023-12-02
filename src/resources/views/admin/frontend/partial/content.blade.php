<form action="{{route('admin.appearance.update')}}" class="add-listing-form mb-5" enctype="multipart/form-data" method="post">
    @csrf

    <input type="hidden" name="type" value="content">
    <input type="hidden" name="key" value="{{request()->route("key")}}">

    <div class="row">
    
        @foreach($appearance->content as $k => $content)
            @if($k == 'images')
                @foreach($content as $imK => $imV)
            
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="{{$imK}}">
                                {{translate(k2t($imK))}} <small class="text-danger">({{@$imV->size}})</small>
                            </label> 

                            <input  data-size = "100x100" id="{{$imK}}" name="image_input[{{ $imK }}]" type="file" class=" preview" >

                            <div class="mt-2 image-preview-section frontend-section-image">

                                @php
                                    $file =  $appearance_content?->file->where('type', $imK)->first()
                                @endphp
                                <img src="{{imageUrl(@$file,"frontend",true)}}" alt="{{@$file->name}}">
                    
                            </div>                      
                                            
                        </div>
                    </div>
                @endforeach
            @elseif($k == 'select')

                @foreach($content as $k => $v)
            
                        <div class="col-lg-6">
                            <div class="form-inner">
                                <label for="{{$k}}">
                                    {{translate(k2t($k))}} <small class="text-danger">*</small>
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

                @php
                    $col =  $content == 'textarea' || $content == 'textarea-editor' ? 12 :6;
                @endphp
                <div class="col-lg-{{$col}}">
                    <div class="form-inner">

                        <label for="{{$k}}">
                            {{translate(k2t($k))}} <small class="text-danger">*</small>
                        </label> 

                

                        @if($content == 'textarea' || $content == 'textarea-editor')
                        
                                <textarea placeholder="{{translate(k2t($k))}}" required @if($content == 'textarea-editor') class="summernote"  @endif name="{{$k}}" id="{{$k}}" cols="30" rows="10">@php echo @$appearance_content->value->$k @endphp</textarea>
                        @else

                                <input value="{{@$appearance_content->value->$k}}" placeholder="{{translate(k2t($k))}}" @if($content  == 'icon' ) class="iconPicker icon"  autocomplete="off" @endif type="{{$content == 'number' ? "number" :"text"}}" name="{{$k}}" id="{{$k}}">
                        
                        @endif
                    </div>

                </div>

            @endif
        @endforeach

        <div class="col-12 ">
            <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                {{translate("Update")}}
            </button>
        </div>
    </div>

</form>