@extends('layouts.master')
@section('content')
     @php
        $breadcrumb = frontend_section()->where("slug",'breadcrumb_section')->first();
     @endphp

     @includeWhen(@site_settings('breadcrumbs') == App\Enums\StatusEnum::true->status(),'frontend.partials.breadcrumb',['breadcrumb' => $breadcrumb])

    <section class="bg-light-1 pt-110 pb-110 ">
        <div class="container">
            <div class="blog-details-wrapper">
                <div class="row g-3 g-lg-2 g-xl-3 position-relative">
                    <div class="col-xl-9 col-lg-8">
                        <div class="blog-details">
                            <div class="blog-thambs">
                                {{-- <img src="{{ imageUrl(config("settings")['file_path']['article']['path']."/".@$article->file->name ,@$article->file->disk)}}" alt="{{@$article->file->name}}"/> --}}
                            </div>

                            <div class="blog-details-content box">
                                <div class="blog-meta d-flex align-item-center justify-content-between flex-column flex-md-row gap-4">
                                    <div class="blog-meta-info">
                                        <div class="blog-meta-info-item">
                                            <i class="fa-duotone fa-timer"></i>
                                            <span>
                                                {{diff_for_humans($article->created_at)}}
                                            </span>

                                            <a href="{{route("article.category",@get_translation($article->category?->slug))}}" class="category">
                                                {{@get_translation($article->category?->title)}}
                                            </a>
                                        </div>

                                        <div class="blog-meta-info-item">
                                            <i class="fa-duotone fa-eye"></i>
                                            <span>{{$article->view}}</span>
                                        </div>

                                        <div class="blog-meta-info-item">
                                            <div class="articles-like">

                                                <button data-id="{{$article->id}}" class="like-btn like article-like ">

                                                    @if(auth_user('web') && in_array(auth_user('web')->id , $article->liked_by ? $article->liked_by : []))
                                                    <i class="isLike fa-solid fa-thumbs-up"></i>
                                                    @else
                                                        <i class="fa-duotone fa-thumbs-up"></i>
                                                    @endif

                                                </button>

                                                <span class="article-likes-count">
                                                    {{$article->likes_count}}
                                                </span>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="blog-meta">
                                    <h2 class="blog-details-title">
                                        {{$article->title}}
                                    </h2>
                                </div>

                                <div class="blog-description">
                                    @php  echo $article->description  @endphp
                                </div>

                                @if(site_settings("social_sharing") == App\Enums\StatusEnum::true->status())
                                    <div class="share">
                                        <span>
                                            {{translate("Share On")}}
                                        <i class="fa-solid fa-share-nodes"></i></span>
                                        <div class="shareOn-social-media mt-0">

                                            <a onclick="social_share('https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}',  'Facebook','600','300');" href="javascript:void(0);"><i class="fa-brands fa-facebook-f"></i>
                                            </a>

                                            <a onclick="social_share('http://twitter.com/share?text={{str_replace("'", "\'", $article->title)}}&url={{url()->current()}}','Twitter','600','450');"
                                                href="javascript:void(0);"><i class="fa-brands fa-twitter"></i>
                                            </a>

                                            <a onclick="social_share('https://api.whatsapp.com/send?text={{str_replace("'", "\'", $article->title)}} {{url()->current()}}','WhatsApp','700','650');" href="javascript:void(0);"><i class="fa-brands fa-whatsapp"></i></a>


                                            <a onclick="social_share('https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}','Linkedin','600','450');" href="javascript:void(0);"><i class="fa-brands fa-linkedin-in"></i></a>


                                            <a onclick="social_share('https://t.me/share/url?url={{url()->current()}}&text={{str_replace("'", "\'", $article->title)}}','Telegram','600','450');" href="javascript:void(0);"><i class="fab fa-telegram-plane "></i></a>

                                            <a href="mailto:?subject={{$article->title}}&amp;body={{url()->current()}}"><i class="fas fa-envelope "></i></a>

                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="blog-comment mt-60">
                                <div class="blog-comment-top mb-30">
                                    <div class="blog-sub-title">
                                        <h3> {{translate("Comments")}} <small>({{$article->comments_count}})</small></h3>
                                    </div>

                                    @if(auth_user('web') && site_settings('link_review') ==  App\Enums\StatusEnum::true->status())
                                        <button data-text="" class="ig-btn btn--primary btn--sm add-comment-btn"><i
                                            class="fa-duotone fa-pen-to-square"></i>
                                            {{translate("Add Comment")}}
                                        </button>
                                    @endif

                                </div>
                                @if(auth_user('web') && site_settings('link_review') ==  App\Enums\StatusEnum::true->status())
                                    <form class="wright-comment comment-section d-none" method="post" action="{{route("article.comment")}}">
                                        @csrf
                                        <div class="p-4">
                                            <input name="article_id" value="{{$article->id}}" type="hidden">
                                            <textarea required id="comment-area" rows="5" name="comment" placeholder="{{translate("Type Here ...")}}">{{old("comment")}}</textarea>
                                            <button type="submit" class="ig-btn btn--sm btn--primary ">
                                                {{translate("Submit")}}
                                            </button>
                                        </div>
                                    </form>
                                @endif

                                <div class="comments">
                                    <div class="comment">

                                    @forelse($article->comments as $comment)

                                        <div class="first-comment">
                                            <div class="d-flex align-items-center">

                                                    @php
                                                    if($comment->admin_id){
                                                            $name =  $comment->admin?->user_name;
                                                            // $imgUrl  =  imageUrl(config("settings")['file_path']['profile']['admin']['path']."/".@$comment->admin->file->name ,@$comment->admin->file->disk);
                                                        }
                                                        else{
                                                            $name =  $comment->user->name;
                                                            // $imgUrl  =  imageUrl(config("settings")['file_path']['profile']['user']['path']."/".@$comment->user->file->name ,@$comment->user->file->disk );
                                                        }
                                                    @endphp
                                                    <img class="rounded-circle me-2" src="{{$imgUrl}}" alt="profile.jpg"/>
                                                    <div class="d-flex flex-column justify-content-center align-items-start fs-5 lh-sm px-2">
                                                        <b class="text-primary fs-4 text-dark">

                                                            {{$name}}
                                                        </b>
                                                        <span class="mt-1">
                                                            {{diff_for_humans($comment->created_at)}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="mt-2 fs-4">
                                                    @if($comment->approved == App\Enums\StatusEnum::false->status() )

                                                        {{translate('This Comment Is Under Review')}}

                                                    @else
                                                        {{$comment->comments}}
                                                    @endif
                                                </p>
                                                @if(auth_user('web') && site_settings('link_review') ==  App\Enums\StatusEnum::true->status() && $comment->approved == App\Enums\StatusEnum::true->status())
                                                    <div class="comment-action">

                                                        <div class="article-comment-like">
                                                            <button data-id ="{{$article->id}}" data-commentId = "{{$comment->id}}" class="like comment-like">
                                                                @if(auth_user('web') && in_array(auth_user('web')->id , $comment->liked_by ? $comment->liked_by : []))
                                                                <i class="isLike fa-solid fa-thumbs-up"></i>
                                                                @else
                                                                    <i class="fa-duotone fa-thumbs-up"></i>
                                                                @endif

                                                            </button>

                                                            <span class="comment-likes-count">
                                                                {{$comment->likes_count}}
                                                            </span>

                                                        </div>

                                                        <button class="replay  "><i data-text="{{$name}}" class="fa-duotone fa-reply-all add-comment-btn"></i> </button>

                                                    </div>
                                                @endif
                                            </div>

                                        @empty
                                            <div class="justify-content-center text-center">
                                                @include('frontend.partials.not_found')
                                            </div>
                                        @endforelse

                                    </div>
                                </div>
                            </div>

                            <div class="mt-60">
                                <div class="blog-sub-title mb-30">
                                    <h3>
                                        {{translate("Realted Post")}}
                                    </h3>
                                </div>

                                <div class="swiper blog-details-slider">
                                    <div class="swiper-wrapper">

                                        @include('frontend.partials.articles',['partialArticles' => $related_articles])

                                    </div>
                                </div>

                                @if($related_articles->count() == 0)

                                    <div class="row">
                                        <div class="col-12 justify-content-center text-center">
                                            <div class="justify-content-center text-center">
                                                @include('frontend.partials.not_found')
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="blog-details-right sticky-side-div">
                            <div class="box">
                                <div class="box-header">
                                    <h4>
                                        {{translate("Latest")}}
                                    </h4>
                                </div>
                                <div>
                                    @forelse($latest_articles as $latestArticle)
                                        <div class="popular-blog-item">
                                            <div class="popular-blog-left">
                                                {{-- <img src="{{imageUrl(config("settings")['file_path']['article']['path']."/".@$latestArticle->file->name ,@$latestArticle->file->disk ) }}" alt="{{@$latestArticle->file->name}}" /> --}}
                                            </div>

                                            <div class="popular-blog-right">
                                                <h4>
                                                    <a href="{{route("article.details",$latestArticle->slug)}}">
                                                        {{($latestArticle->title)}}
                                                    </a>
                                                </h4>
                                                <span>  {{diff_for_humans($latestArticle->created_at)}}</span>
                                            </div>
                                        </div>

                                    @empty
                                        <div class="justify-content-center text-center">
                                            @include('frontend.partials.not_found')
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="box">
                                <div class="box-header">
                                    <h4>
                                        {{translate("Categories")}}
                                    </h4>
                                </div>
                                <div class="blog-category">
                                    @foreach($categories as $category)
                                        <a @if($article->category?->id == $category->id )  class="article-active"  @endif  href="{{route("article.category",@get_translation($category->slug))}}">
                                            {{@get_translation($category->title)}}
                                            <small>
                                                {{$category->articles_count}}
                                            </small>
                                    </a>
                                    @endforeach
                                </div>
                            </div>

                            @if(add_shortcode("article_details") && site_settings("google_ads") != App\Enums\StatusEnum::true->status())
                                <div class="box-sm shadow-one">
                                     @php echo add_shortcode("article_details") @endphp
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";
        $(document).on('click',".add-comment-btn",function(e){
            var text = $(this).attr('data-text');
            console.log(text)
            toggleCommentSection(text)
        })

        function toggleCommentSection(text){
            $('#comment-area').html(text)
            $(".comment-section").toggleClass("d-none",1000)
        }
	})(jQuery);
</script>
@endpush
