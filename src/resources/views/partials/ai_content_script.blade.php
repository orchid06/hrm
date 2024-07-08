<script>
	(function($){
       	"use strict";
    
        
        /** ai content genaration event */
      
        $(document).on('click','.update',function(e){

            var content = JSON.parse($(this).attr('data-content'))
            var modal = $('#content-form')
            modal.find('#contentForm').attr('action','{{request()->routeIs("user.*") ? route("user.ai.content.update") :route("admin.content.update")}}')
            modal.find('.modal-title').html("{{translate('Update Content')}}")

            modal.find('input[name="name"]').val(content.name)
            modal.find('input[name="id"]').attr('disabled',false)
            modal.find('input[name="id"]').val(content.id)
            modal.find('textarea[name="content"]').val(content.content)
            modal.modal('show')
        })


        $(document).on('change','#category',function(e){

            var id = $(this).val()
            $(".template-prompt").addClass('d-none');
            $(".generate-btn").addClass('d-none');
            if(id != ""){
                getTemplate();
                subCategories(id);
            }
            e.preventDefault()
        })


        $(document).on('change','#sub_category_id',function(e){

            $(".template-prompt").addClass('d-none');
            $(".generate-btn").addClass('d-none');
            var id = $(this).val()

            if(id != ""){
                getTemplate();
            }
            e.preventDefault()
        })


        function subCategories(id){

            var url = '{{ route("get.subcategories", ["category_id" => ":id", "html" => ":html"]) }}';
            url = url.replace(':id', id).replace(':html', true);

            $.ajax({

                method:'get',
                url: url,
                dataType: 'json',

                beforeSend: function() {
                    $('.card-loader').removeClass('d-none');
                },

                success: function(response){
                    $('#sub_category_id').html('')
                    if(response.status){
                        $('#sub_category_id').html(response.html)
                    }
                
                },
                error: function (error){
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            if((error.responseJSON.message)){
                                toastr(error.responseJSON.message,'danger')
                            }
                            else{
                                toastr( error.responseJSON.error,'danger')
                            }
                        }
                    }
                    else{
                        toastr(error.message,'danger')
                    }
                },

                complete: function() {
                    $('.card-loader').addClass('d-none');
                },
            })
        }


        function getTemplate(){

            var categoryId = $('#category').find(":selected").val();
            var subcategory = $('#sub_category_id').find(":selected").val();

            $.ajax({
                method:'post',
                url:"{{route('get.template')}}",
                dataType: 'json',
                beforeSend: function() {
                    $('.card-loader').removeClass('d-none');
                },

                data: {
                    "category_id"     :categoryId,
                    "sub_category_id" :subcategory,
                    "user_id"         :"{{request()->routeIs('user.*') ? $user->id : null}}",
                    "_token"          :"{{csrf_token()}}",
                },
                success: function(response){

                    if(response.status){
                        $('.selectTemplate').html(response.html)
                    }
                    else{
                        toastr(response.message,'danger') 
                    }

                },
                error: function (error){
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            if((error.responseJSON.message)){
                                toastr(error.responseJSON.message,'danger')
                            }
                            else{
                                toastr( error.responseJSON.error,'danger')
                            }
                        }
                    }
                    else{
                        toastr(error.message,'danger')
                    }
                },

                complete: function() {
                    $('.card-loader').addClass('d-none');
                },
            
            })

        }


        $(document).on('change','.selectTemplate',function(e){

            var id  =  $(this).val()

            if(id){
                var url = '{{ route("template.config", ["id" => ":id"]) }}';
                url = url.replace(':id', id).replace(':html', true);
                $.ajax({
                    method:'get',
                    url:url,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.card-loader').removeClass('d-none');
                    },

                    success: function(response){

                        if(response.status){
                            $(".template-prompt").removeClass('d-none');
                            $(".template-prompt").html(response.html);

                            $(".generate-btn").removeClass('d-none');
                            
                        }else{
                            toastr( "Template not found!!",'danger')
                        }

                    },
                    error: function (error){
                        if(error && error.responseJSON){
                            if(error.responseJSON.errors){
                                for (let i in error.responseJSON.errors) {
                                    toastr(error.responseJSON.errors[i][0],'danger')
                                }
                            }
                            else{
                                if((error.responseJSON.message)){
                                    toastr(error.responseJSON.message,'danger')
                                }
                                else{
                                    toastr( error.responseJSON.error,'danger')
                                }
                            }
                        }
                        else{
                            toastr(error.message,'danger')
                        }
                    },
                    complete: function() {
                        $('.card-loader').addClass('d-none');
                    },
                
                })
            }


        })


       var inputObj = {}; 

        $(document).on('change',".prompt-input",function(e){
            var value = $(this).val();
            var index  = $(this).attr('data-name');
            if(value == ""){
                if (inputObj.hasOwnProperty(index)) {
                    delete inputObj[index];
                }
            }
            else{
                inputObj[index] = value;
            }

            replace_prompt();

        })


        function replace_prompt(){

            var originalPrompt      = $('#promptPreview').attr('data-prompt_input');
            var prompt              = originalPrompt;

            var len = Object.keys(inputObj).length

            if(len > 0){
                for (var index in inputObj) {
                    prompt    = prompt.replace(index,inputObj[index]);
                }
                $('#promptPreview').html(prompt);
            }
            else{
                $('#promptPreview').html($('#promptPreview').attr('data-prompt_input'));
            }


        }


        $(document).on('submit','.ai-content-form',function(e){

            var data =   new FormData(this)
            var route =  $(this).attr('data-route')
            $.ajax({
            method:'post',
            url: route,
            dataType: 'json',
            beforeSend: function() {

                @if("{{request()->routeIs('user.*')}}")
                   $('.ai-btn').html(`{{translate('Generate')}} <span><i class="bi bi-arrow-up-right"></i></span>`)
                    $('.ai-btn').html(`{{translate('Generate')}}<div class="spinner-border text-success" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>`)
                @else
                        $('.ai-btn').addClass('btn__dots--loading');
                        $('.ai-btn').append('<span class="btn__dots"><i></i><i></i><i></i></span>');
                @endif

            },
            cache: false,
            processData: false,
            contentType: false,
            data: data,
            success: function(response){

                if(response.status){
                    $('#content').html(response.message)
                    $('#ai-form').fadeOut()
                    $('.ai-content-div').removeClass('d-none')
                }
                else{
                    toastr(response.message,"danger")   
                }

            },
            error: function (error){
                if(error && error.responseJSON){
                    if(error.responseJSON.errors){
                        for (let i in error.responseJSON.errors) {
                            toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }
                    else{
                        if((error.responseJSON.message)){
                            toastr(error.responseJSON.message,'danger')
                        }
                        else{
                            toastr( error.responseJSON.error,'danger')
                        }
                    }
                }
                else{
                    toastr(error.message,'danger')
                }
            },
            complete: function() {

                @if("{{request()->routeIs('user.*')}}")
                    $('.ai-btn').html(`{{translate('Generate')}} <span><i class="bi bi-arrow-up-right"></i></span>`)
                @else
                    $('.ai-btn').removeClass('btn__dots--loading');
                    $('.ai-btn').find('.btn__dots').remove();
                @endif

            },
            })

            e.preventDefault();
        });


	})(jQuery);
</script>