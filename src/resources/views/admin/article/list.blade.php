@extends('admin.layouts.master')
@section('content')

    <div class="i-card-md">
       
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action='{{route("admin.article.bulk")}}' method="post">
                        @csrf
                        <input type="hidden" name="bulk_id" id="bulkid">
                        <input type="hidden" name="value" id="value">
                        <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_article') || check_permission('update_article') || check_permission('delete_article'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_article') || check_permission('delete_article'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('delete_article'))
                                            <li>
                                                <button data-type="delete"  class="dropdown-item bulk-action-modal">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                          
                                        @if(check_permission('update_article'))

                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulk-action-btn" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach

                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="is_feature" value="{{$v}}" class="dropdown-item bulk-action-btn" > 
                                                        {{$v == App\Enums\StatusEnum::true->status() ? 'Feature' :"Exclude "}}
                                                    </button>
                                                </li>
                                            @endforeach

                                        @endif
                                    </ul>
                                </div>
                            @endif
                        
                            @if(check_permission('create_article'))
                                <div class="col-md-4 d-flex justify-content-start">
                                    <div class="action">
                                        <a href="{{route('admin.article.create')}}"    class="i-btn btn--sm success">
                                            <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif

                    <div class="col-md-8 d-flex justify-content-md-end justify-content-start">

                        <div class="filter-wrapper">
                            <button class="i-btn btn--primary btn--sm filter-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="las la-filter"></i>
                            </button>
                            <div class="filter-dropdown">
                                <form action="{{route(Route::currentRouteName())}}" method="get">
                                    <div class="form-inner">
                                        <select name="status" id="status" class="select2">
                                            <option value="">
                                                {{translate('Select status')}}
                                            </option>
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                            <option  {{request()->input('status') ==   $v ? 'selected' :""}} value="{{$v}}"> {{translate($k)}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-inner">
                                        <select name="category" id="category" class="select2">
                                            <option value="">
                                                {{translate('Select Category')}}
                                            </option>
                                            @foreach($categories as $category)
                                            <option  {{$category->slug ==   request()->input('category') ? 'selected' :""}} value="{{$category->slug}}"> {{$category->title}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-inner">
                                        <input name="search" value='{{request()->input("search")}}' type="search" placeholder="{{translate('Search by  title')}}">
                                    </div>

                                    <button class="i-btn btn--sm info w-100">
                                        <i class="las la-sliders-h"></i>
                                    </button>
                                </form>
                            </div>  
                        </div>
                        <div class="ms-3">
                            <a href="{{route('admin.article.list')}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container position-relative">
                @include('admin.partials.loader')
                
                <table >
                    <thead>
                        <tr>
                            <th scope="col">
                                @if( check_permission('update_article') || check_permission('delete_article'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Title')}}
                            </th>
                            
                            <th scope="col">
                                {{translate('Category')}}
                            </th>

                            <th scope="col">
                                {{translate('Created By')}}
                            </th>

                            <th scope="col">
                                {{translate('Status')}}
                            </th>


                            <th scope="col">
                                {{translate('Feature')}}
                            </th>

                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($articles as $article)
  
                                <tr>
                                    <td data-label="#">
                                        @if(check_permission('create_article') || check_permission('update_article') || check_permission('delete_article'))
                                            <input type="checkbox" value="{{$article->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$article->id}}" />
                                        @endif
                                        {{$loop->iteration}}
                                    </td>

                                    <td data-label='{{translate("Title")}}'>
                                        <div class="user-meta-info d-flex align-items-center gap-2">
                                            <img class="rounded-circle avatar-sm" src='{{imageUrl(@$article->file,"article",true)}}' alt="{{@$article->file->name}}">

                                            <p>	 {{$article->title}}</p>
                                        </div>
                                    </td>



                                    <td data-label='{{translate("Category")}}'>
                                        {{@($article->category->title)}}
                                    </td>

                                    <td data-label='{{translate("Created by")}}'>
                                        <span class="i-badge capsuled info">
                                            {{$article->createdBy->name}}
                                        </span>
                                    </td>

                                    <td data-label='{{translate("Status")}}'>
                                        <div class="form-check form-switch switch-center">
                                            <input {{!check_permission('update_article') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                data-column="status"
                                                data-route="{{ route('admin.article.update.status') }}"
                                                data-status="{{ $article->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                data-id="{{$article->uid}}" {{$article->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                            id="status-switch-{{$article->id}}" >
                                            <label class="form-check-label" for="status-switch-{{$article->id}}"></label>
                                        </div>
                                    </td>

                                    <td data-label='{{translate("Feature")}}'>
                                        <div class="form-check form-switch switch-center">
                                            <input {{!check_permission('update_article') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                data-column="is_feature"
                                                data-route="{{ route('admin.article.update.status') }}"
                                                data-status="{{ $article->is_feature == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                data-id="{{$article->uid}}" {{$article->is_feature ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                            id="status-switch-feature-{{$article->id}}" >
                                            <label class="form-check-label" for="status-switch-feature-{{$article->id}}"></label>
                                        </div>
                                    </td>

                                    <td data-label='{{translate("Options")}}'>
                                        <div class="table-action">
                                            @if(check_permission('update_article') || check_permission('delete_article') )


                                                @if(check_permission('update_article') )
                                                    <a  href="{{route('admin.article.edit',$article->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
                                                @endif

                                                @if(check_permission('delete_article'))
                              
                                                        <a href="javascript:void(0);" data-href="{{route('admin.article.destroy',$article->uid)}}" class="pointer delete-item icon-btn danger">

                                                        <i class="las la-trash-alt"></i></a>
                                                   
                                                @endif
                                            @else
                                                {{translate('N/A')}}
                                            @endif

                                        </div>
                                    </td>
                               </tr>
                         
                            @empty

                            <tr>
                                <td class="border-bottom-0" colspan="100">
                                    @include('admin.partials.not_found',['custom_message' => "No Articles found!!"])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="Paginations">

                    {{ $articles->links() }}
                
            </div>
        </div>
    </div>

@endsection
@section('modal')

    @include('modal.delete_modal')

    @include('modal.bulk_modal')

@endsection


@push('script-push')
<script>
	(function($){

        $(".select2").select2({
           
        })

	})(jQuery);
</script>
@endpush





