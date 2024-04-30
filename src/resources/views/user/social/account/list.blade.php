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
            <ul class="nav nav-tabs gap-4 style-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-one" data-bs-toggle="tab" data-bs-target="#tab-one-pane" type="button" role="tab" aria-controls="tab-one-pane" aria-selected="true"><span><img src="https://i.ibb.co/NLk868y/facebook.png" alt="facebook"></span>Facebook</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-two" data-bs-toggle="tab" data-bs-target="#tab-two-pane" type="button" role="tab" aria-controls="tab-two-pane" aria-selected="false"><span><img src="https://i.ibb.co/QJ7MCHY/instagram.png" alt="instagram"></span>Instagram</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-three" data-bs-toggle="tab" data-bs-target="#tab-three-pane" type="button" role="tab" aria-controls="tab-three-pane" aria-selected="false"><span><img src="https://i.ibb.co/Rg1Vz7X/twitter.png" alt="twitter"></span>Twitter</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-four" data-bs-toggle="tab" data-bs-target="#tab-four-pane" type="button" role="tab" aria-controls="tab-four-pane" aria-selected="false"><span><img src="https://i.ibb.co/mcGZcTg/linkedin.png" alt="linkedin"></span>Linkedin</buttons>
                </li>
            </ul>
        </div>

        <div class="i-card border">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one-pane" role="tabpanel" aria-labelledby="tab-one" tabindex="0">
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
                <div class="tab-pane fade" id="tab-two-pane" role="tabpanel" aria-labelledby="tab-two" tabindex="0">
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
                <div class="tab-pane fade" id="tab-three-pane" role="tabpanel" aria-labelledby="tab-three" tabindex="0">
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
                <div class="tab-pane fade" id="tab-four-pane" role="tabpanel" aria-labelledby="tab-four" tabindex="0">
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
        </div>
    </div>

@endsection


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
