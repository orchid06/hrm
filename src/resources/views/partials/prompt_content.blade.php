    <div class="col-lg-12">
        <div class="form-inner">
            <label for="language"> 
                {{translate('Select input & output language')}} <small class="text-danger">*</small>
            </label>
            
            <select name="language" class="select2" id="language">
                @foreach ($languages as $language )
                    <option {{session()->get('locale') == $language->code ? "selected" :"" }} value="{{$language->name}}">
                        {{$language->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if($template->prompt_fields)
        @foreach ($template->prompt_fields as  $key => $input)

            <div class="col-lg-12">
                <div class="form-inner">

                    <label for="{{  $key }}"> 
                        {{ @$input->field_label }} @if(@$input->validation == 'required') <small class="text-danger">*</small>@endif
                    </label>

                    @if($input->type == "text")
                        <input data-name="{{'{'.@$input->field_name.'}'}}" placeholder="{{ @$input->field_label }}" @if(@$input->validation == 'required') required @endif  name="custom[{{ @$input->field_name }}]" id=" {{ $key }} " value="{{old("custom.".@$input->field_name)}}" type="text" class="prompt-input">
                    @else
                        <textarea class="prompt-input" data-name="{{'{'.@$input->field_name.'}'}}"  placeholder="{{ @$input->field_label }}" @if(@$input->validation == 'required') required @endif name="custom[{{ @$input->field_name }}]"  id=" {{ $key }} "  cols="30" rows="6">{{old("custom.".@$input->field_name)}}</textarea>
                    @endif

                </div>
            </div>

        @endforeach
    @endif

    <div class="col-lg-12">
        <div class="form-inner">
            <label for="promptPreview"> 
                {{translate('Prompt Preview')}} 
            </label>


            <textarea data-prompt_input = "{{$template->custom_prompt}}" readonly  id="promptPreview" cols="30" rows="10">{{$template->custom_prompt}}</textarea>

        </div>
    </div>

    <div class="col-lg-12 mb-3">
        <div class="accordion" id="advanceOption">
            <div class="accordion-item">
            <h2 class="accordion-header" id="advanceContent">
                <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#advanceAcc"
                aria-expanded="true"
                aria-controls="advanceAcc">
                    {{translate("Advance Options")}} 
                    <i title="{{translate('Browse More Fields')}}" class="ms-1 las la-question-circle"></i>
                </button>
            </h2>
            <div
                id="advanceAcc"
                class="accordion-collapse collapse"
                aria-labelledby="advanceContent"
                data-bs-parent="#advanceOption">
                <div class="accordion-body">

                    <div class="form-inner">
                        <label for="max_result">
                            {{translate("Max Results Length")}} <i title="{{translate('Maximum words for each result')}}" class="ms-1 pointer las la-question-circle"></i>
                        </label>

                        <input placeholder="{{translate("Enter number")}}" type="number" min="1" name="max_result"  value="{{old("max_result")}}" >

                    </div>

                    <div class="form-inner">
                        <label for="ai_creativity"
                        class="form-label">{{ translate('Ai Creativity Level') }}
                        <small class="text-danger" >*</small></label>

                        <select class="select2" id="ai_creativity" name="ai_creativity" >
                                <option  value="">
                                    {{translate("Select Creativity")}}
                                </option>
                                @foreach (Arr::get(config('settings'),'default_creativity',[]) as $k => $v )
                                    <option  value="{{$v}}" >
                                        {{ $k }}
                                    </option>
                                @endforeach
                            
                        </select>
                    </div>

                    <div class="form-inner">

                        <label for="content_tone"
                            class="form-label">{{ translate('Content Tone') }}
                            <small class="text-danger" >*</small></label>

                            <select  class="select2" id="content_tone" name="content_tone">

                                    <option value="">
                                        {{translate("Select Tone")}}
                                    </option>
                                @foreach (Arr::get(config('settings'),'ai_default_tone',[]) as $v )
                                        <option {{old("content_tone") == $v ? 'selected' :""}} value="{{$v}}">
                                            {{ $v }}
                                        </option>
                                @endforeach
                                
                            </select>
                    </div>

                </div>
            </div>
            </div>
        </div>
    </div>