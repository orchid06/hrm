@extends('layouts.master')
@section('content')

    @php
        $user                   = auth_user('web');
        $subscription           = $user->runningSubscription;
        $accessPlatforms         = (array) ($subscription ? @$subscription->package->social_access->platform_access : []);

        $platforms = get_platform()
                        ->whereIn('id', $accessPlatforms )
                        ->where("status",App\Enums\StatusEnum::true->status())
                        ->where("is_integrated",App\Enums\StatusEnum::true->status());

    @endphp
    <div class="row">
        <div class="i-card mb-4 border">
            <ul class="social-account-list-2">
                <li>
                        <a class="active"><span><img src="https://i.ibb.co/NLk868y/facebook.png" alt="facebook"></span>Facebook</a>
                </li>
                <li>
                      <a ><span><img src="https://i.ibb.co/QJ7MCHY/instagram.png" alt="instagram"></span>Instagram</a>
                </li>
                <li>
                      <a><span><img src="https://i.ibb.co/Rg1Vz7X/twitter.png" alt="twitter"></span>Twitter</a>
                </li>
                <li>
                    <a  ><span><img src="https://i.ibb.co/mcGZcTg/linkedin.png" alt="linkedin"></span>Linkedin</a>
                </li>
            </ul>
        </div>

        <div class="i-card border">


            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                Accounts information
                            </th>
                            <th scope="col">
                                Connection status
                            </th>

                            <th scope="col">
                                Connection type
                            </th>

                            <th scope="col">
                                Account type
                            </th>
                            <th scope="col">
                                Status
                            </th>

                            <th scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Accounts information">
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <div class="avarar-sm"><img src="https://i.ibb.co/zrjPsCr/social-1.jpg" alt="social-1"></div>
                                    <p class="mb-0">News nasa</p>
                                </div> 
                            </td>
                            <td data-label="Connection status">
                                <a href="#" class="i-badge danger">Disconnected</a>
                            </td>

                            <td data-label="Subject">
                                <a href="#" class="i-badge info">Official</a>
                            </td>

                            <td data-label="Status">
                                <a href="#" class="i-badge success">Page</a>
                            </td>

                            <td data-label="Status">
                                <div class="form-check form-switch switch-center">
                                    <input  
                                        type="checkbox" 
                                        class="status-update form-check-input"
                                        data-column="status"
                                        id="status-switch-one" >
                                    <label class="form-check-label" for="status-switch-one"></label>
                                </div>
                            </td>
                            <td data-label="Action">
                                <div class="table-action">
                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm info">
                                        <i class="bi bi-plug"></i>
                                    </a>
                                    <a  href="javascript:void(0);" data-href="#" data-toggle="tooltip" data-placement="top" title="delete"
                                        class="icon-btn icon-btn-sm danger delete-item">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Accounts information">
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <div class="avarar-sm"><img src="https://i.ibb.co/zrjPsCr/social-1.jpg" alt="social-1"></div>
                                    <p class="mb-0">News nasa</p>
                                </div> 
                            </td>
                            <td data-label="Connection status">
                                <a href="#" class="i-badge danger">Disconnected</a>
                            </td>

                            <td data-label="Subject">
                                <a href="#" class="i-badge info">Official</a>
                            </td>

                            <td data-label="Status">
                                <a href="#" class="i-badge success">Page</a>
                            </td>

                            <td data-label="Status">
                                <div class="form-check form-switch switch-center">
                                    <input  
                                        type="checkbox" 
                                        class="status-update form-check-input"
                                        data-column="status"
                                        id="status-switch-one" >
                                    <label class="form-check-label" for="status-switch-one"></label>
                                </div>
                            </td>
                            
                            <td data-label="Action">
                                <div class="table-action">
                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm info">
                                        <i class="bi bi-plug"></i>
                                    </a>

                                    <a  href="javascript:void(0);" data-href="#" data-toggle="tooltip" data-placement="top" title="delete"
                                        class="icon-btn icon-btn-sm danger delete-item">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Accounts information">
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <div class="avarar-sm"><img src="https://i.ibb.co/zrjPsCr/social-1.jpg" alt="social-1"></div>
                                    <p class="mb-0">News nasa</p>
                                </div> 
                            </td>
                            <td data-label="Connection status">
                                <a href="#" class="i-badge danger">Disconnected</a>
                            </td>

                            <td data-label="Subject">
                                <a href="#" class="i-badge info">Official</a>
                            </td>

                            <td data-label="Status">
                                <a href="#" class="i-badge success">Page</a>
                            </td>

                            <td data-label="Status">
                                <div class="form-check form-switch switch-center">
                                    <input  
                                        type="checkbox" 
                                        class="status-update form-check-input"
                                        data-column="status"
                                        id="status-switch-one" >
                                    <label class="form-check-label" for="status-switch-one"></label>
                                </div>
                            </td>
                            
                            <td data-label="Action">
                                <div class="table-action">
                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm info">
                                        <i class="bi bi-plug"></i>
                                    </a>

                                    <a  href="javascript:void(0);" data-href="#" data-toggle="tooltip" data-placement="top" title="delete"
                                        class="icon-btn icon-btn-sm danger delete-item">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Accounts information">
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <div class="avarar-sm"><img src="https://i.ibb.co/zrjPsCr/social-1.jpg" alt="social-1"></div>
                                    <p class="mb-0">News nasa</p>
                                </div> 
                            </td>
                            <td data-label="Connection status">
                                <a href="#" class="i-badge danger">Disconnected</a>
                            </td>

                            <td data-label="Subject">
                                <a href="#" class="i-badge info">Official</a>
                            </td>

                            <td data-label="Status">
                                <a href="#" class="i-badge success">Page</a>
                            </td>

                            <td data-label="Status">
                                <div class="form-check form-switch switch-center">
                                    <input  
                                        type="checkbox" 
                                        class="status-update form-check-input"
                                        data-column="status"
                                        id="status-switch-one" >
                                    <label class="form-check-label" for="status-switch-one"></label>
                                </div>
                            </td>
                            
                            <td data-label="Action">
                                <div class="table-action">
                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="#"
                                        class="icon-btn icon-btn-sm info">
                                        <i class="bi bi-plug"></i>
                                    </a>

                                    <a  href="javascript:void(0);" data-href="#" data-toggle="tooltip" data-placement="top" title="delete"
                                        class="icon-btn icon-btn-sm danger delete-item">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>



    <!-- Social Account -->
        <div class="i-card mb-4 border mt-5">
            <h4 class="card--title mb-4">Social Accounts Connection</h4>
            <ul class="account-connect-list" id="myTab" role="tablist">
                <li>
                    <button><span><img src="https://i.ibb.co/Ht50KmY/facebook-10.png" alt="facebook-10"></span>Facebook</button>
                    <div class="button-group">
                        <button class="i-btn btn--md btn--outline capsuled" type="button" data-bs-toggle="modal" data-bs-target="#face-official">Official</button>
                        <button class="i-btn btn--md btn--outline capsuled" type="button" data-bs-toggle="modal" data-bs-target="#face-unofficial">Unofficial</button>
                    </div>
                </li>
                <li>
                    <button><span><img src="https://i.ibb.co/9WrsbqH/instagram-2.png" alt="instagram-2"></span>instagram</button>
                    <div class="button-group">
                        <button class="i-btn btn--md btn--outline capsuled">Official</button>
                        <button class="i-btn btn--md btn--outline capsuled">Unofficial</button>
                    </div>
                </li>
                <li>
                    <button><span><img src="https://i.ibb.co/XLPsPPg/twitter-2.png" alt="twitter-2"></span>Twitter</button>
                    <div class="button-group">
                        <button class="i-btn btn--md btn--outline capsuled">Official</button>
                        <button class="i-btn btn--md btn--outline capsuled">Unofficial</button>
                    </div>
                </li>
                <li>
                    <button><span><img src="https://i.ibb.co/9WmQjvZ/linkedin-2.png" alt="linkedin-2"></span>LinkedIn</button>
                    <div class="button-group">
                        <button class="i-btn btn--md btn--outline capsuled">Official</button>
                        <button class="i-btn btn--md btn--outline capsuled">Unofficial</button>
                    </div>
                </li>
                <li>
                    <button><span><img src="https://i.ibb.co/XYkxVt6/titktok.png" alt="titktok"></span>Tiktok</button>
                    <div class="button-group">
                        <button class="i-btn btn--md btn--outline capsuled">Official</button>
                        <button class="i-btn btn--md btn--outline capsuled">Unofficial</button>
                    </div>
                </li>
                <li>
                    <button><span><img src="https://i.ibb.co/6NRpN0D/YouTube.png" alt="YouTube"></span>You Tube</button>
                    <div class="button-group">
                        <button class="i-btn btn--md btn--outline capsuled">Official</button>
                        <button class="i-btn btn--md btn--outline capsuled">Unofficial</button>
                    </div>
                </li>
            </ul>
        </div>

@endsection


    <!-- Modal -->
    <div class="modal fade" id="face-official" tabindex="-1" aria-labelledby="officialLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Official</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h4 class="card--title mb-4">Connect account</h4>
                    <div class="text-center d-block">
                        <button class="i-btn btn--lg btn--primary capsuled mx-auto" type="submit">Connect</button>
                    </div>
                    <div class="notice-message">
                        <span>Note:</span>
                        <p>I am here to assist you with any questions or information you may need. Please feel free to ask me anything, and I will do my best to help. They may have various technologies in use, but I do not have information on any specific robot.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="face-unofficial" tabindex="-1" aria-labelledby="unofficialLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Official</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h4 class="card--title mb-4">Connect account</h4>
                    <div class="text-center d-block">
                        <button class="i-btn btn--lg btn--primary capsuled mx-auto" type="submit">Connect</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('modal')
    @include('modal.delete_modal')
    <div class="modal fade" id="reconnect-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reconnect-modal"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{translate('Reconnect Account')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('user.social.account.reconnect')}}" id="platformForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input   hidden name="id" type="text">
                            <div class="col-lg-12" id ="accountConfig">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                            {{translate("Close")}}
                        </button>
                        <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')

<script>
  "use strict";
   $(".user").select2({

    });


    $(document).on('click','.reconnect',function(e){

        var account        = JSON.parse($(this).attr('data-account'));
        var id             = account.id;

        var modal          = $('#reconnect-modal')
        modal.find('input[name="id"]').val(id)
        var html = "";

        html+= `<div class="form-inner">
                    <label for="token" class="form-label" >
                        {{translate('Access Token')}}  <span  class="text-danger">*</span>
                    </label>

                   <input value="${account.account_information.token}" required type="text" name="access_token">
                </div>`;
        $("#accountConfig").html(html)
        modal.modal('show')
    })

</script>
@endpush
