
<!DOCTYPE html>
<html lang="{{App::getLocale()}}" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <title>{{@site_settings("site_name")}} {{site_settings('title_separator')}} {{@translate($title)}}</title>
    <link rel="shortcut icon" href="{{imageUrl(@site_logo('favicon')->file,'favicon',true)}}">
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/line-awesome.min.css')}}" rel="stylesheet"  type="text/css"/>
    <link href="{{asset('assets/global/css/nice-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/simplebar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/main.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/custom.css')}}" rel="stylesheet" type="text/css" />
    @include('partials.theme')
    @stack('style-include')
    @stack('styles')

  </head>
  <body>
    @include('admin.partials.topbar')
    <div class="dashboard-wrapper">
        @include('admin.partials.sidebar')
        <div class="main-content">
            @if(!request()->routeIs('admin.home') && !request()->routeIs('admin.social.post.analytics'))
                @include('admin.partials.breadcrumb')
            @endif
            @yield('content')
        </div>
    </div>
    @yield("modal")

    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/global/js/simplebar.min.js')}}"></script>
    <script  src="{{asset('assets/global/js/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/app.js')}}"></script>
    <script src="{{asset('assets/global/js/main.js')}}"></script>
    <script  src="{{asset('assets/global/js/nice-select.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script  src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>


    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')

    <script>

    (function($){
        "use strict";

        var inputTags = document.querySelectorAll('input[type="checkbox"]');

        inputTags.forEach(function(inputTag){

            if(inputTag.hasAttribute('disabled')){
                inputTag.style.backgroundColor = 'rgba(0,0,0,.8)';
            }
        })

        window.onload = function () {
          $('.table-loader').addClass("d-none");

        }

        // update status event start
        $(document).on('click', '.status-update', function (e) {
            const id = $(this).attr('data-id')
            const key = $(this).attr('data-key')
            var column = ($(this).attr('data-column'))
            var route = ($(this).attr('data-route'))
            var modelName = ($(this).attr('data-model'))
            var status = ($(this).attr('data-status'))
            const data = {
                'id': id,
                'model': modelName,
                'column': column,
                'status': status,
                'key': key,
                "_token" :"{{csrf_token()}}",
            }
            updateStatus(route, data)
        })

        // update status method
        function updateStatus(route, data) {
            var responseStatus;
            $.ajax({
                method: 'POST',
                url: route,
                data: data,
                dataType: 'json',
                success: function (response) {

                    if (response) {
                        responseStatus = response.status? "success" :"danger"
                        toastr(response.message,responseStatus)
                        if(response.reload){
                            location.reload()
                        }
                    }
                },
                error: function (error) {
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            toastr( error.responseJSON.error,'danger')
                        }
                    }
                    else{
                        toastr(error.message,'danger')
                    }
                }
            })
        }

        // read notification
        $(document).on('click','.read-notification',function(e){
            var href = $(this).attr('data-href')
            var id = $(this).attr('data-id')
            readNotification(href,id)
            e.preventDefault()
        })

        // read Notification
        function readNotification(href,id){
            $.ajax({
                method:'post',
                url: "{{route('admin.read.notification')}}",
                data:{
                    "_token": "{{ csrf_token()}}",
                    'id':id
                },
                dataType: 'json'
                }).then(response =>{
                if(!response.status){
                    toastr(response.message,'danger')
                }
                else{
                    window.location.href = href
                }}).fail((jqXHR, textStatus, errorThrown) => {
                    toastr(jqXHR.statusText, 'danger');
                });
        }

        /** delete ,restore , bulk action */

        $(document).on('click','.bulk-action-btn' ,function(e){

            var type = $(this).attr("data-type")
            var value = $(this).val()

            const checkedIds = $('.data-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            $('#bulkid').val(JSON.stringify(checkedIds));
            $('#value').val(value);
            $('#type').val(type);

            $("#bulkActionForm").submit()

        });

        $(document).on('click','.bulk-action-modal',function(e){
            var type = $(this).attr("data-type");
            var src = "{{asset('assets/images/trash-bin.gif')}}";
            $('.bulk-btn').html('{{translate("Delete")}}')
            if(type){
                if(type != "delete"){
                    $('.bulk-btn').attr("data-type",type)
                    $('.bulk-btn').val(type)
                    $('.bulk-warning').html($(this).attr("data-message"))
                    if(type == 'restore'){
                        $('.bulk-btn').html('{{translate("Restore")}}')
                         src = "{{asset('assets/images/restore.gif')}}";
                    }
                }
            }

            $(".bulk-warning-image").attr("src",src)
            var modal = $('#bulkActionModal')
            modal.modal('show')
        })

        //delete event start
        $(document).on('click', ".delete-item", function (e) {
            e.preventDefault();
            var href = $(this).attr('data-href');
            var message = 'Are you sure you want to remove these record ?'
            if (($(this).attr('data-message'))) {
                message = $(this).attr('data-message')
            }
            var src = "{{asset('assets/images/trash-bin.gif')}}";
            $('.action-img').attr("src",src)
            $("#action-href").attr("href", href);
            $(".warning-message").html(message)
            $("#actionModal").modal("show");
        })

        //restore event start
        $(document).on('click', ".restore-item", function (e) {

            e.preventDefault();
            var href = $(this).attr('data-href');

            var src = "{{asset('assets/images/restore.gif')}}";
            var message = 'Are you sure! you want to restore these record ?'
            if (($(this).attr('data-message'))) {
                message = $(this).attr('data-message')
            }
            $("#action-href").attr("href", href);
            $('.action-img').attr("src",src)
            $(".warning-message").html(message)
            $("#actionModal").modal("show");
        })

        // update seettings
        $(document).on('submit','.settingsForm',function(e){

                var data =   new FormData(this)
                var route = "{{route('admin.setting.store')}}"
                if($(this).attr('data-route')){
                route = $(this).attr('data-route')
                }
                $.ajax({
                method:'post',
                url: route,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                data: data,
                success: function(response){
                    var className = 'success';
                    if(!response.status){
                        className = 'danger';
                    }
                    toastr( response.message,className)
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
                }
            })

            e.preventDefault();
        });

        if (!$(".Paginations").find("nav").length > 0) {
            $(".Paginations").addClass('d-none')
        }

        // Summer note
        $(document).on("click", ".close", function (e) {
            $(this).closest(".modal").modal("hide");
        });

        $(document).on('click', '.note-btn.dropdown-toggle', function (e) {
            var $clickedDropdown = $(this).next();
            $('.note-dropdown-menu.show').not($clickedDropdown).removeClass('show');
            $clickedDropdown.toggleClass('show');
            e.stopPropagation();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.note-btn.dropdown-toggle').length) {
                $(".note-dropdown-menu").removeClass("show");
            }
        });

    })(jQuery);
    </script>
  </body>
</html>
