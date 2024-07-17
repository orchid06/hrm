<section class="inner-banner">

    @php
        $breadcrumbContent      = get_content("content_breadcrumb")->first();
        $breadcrumbIMG          = @$breadcrumbContent->file?->where("type",'banner_image')->first();
        $breadcrumbSize         = get_appearance_img_size('breadcrumb','content','banner_image');
    @endphp
 
    <div class="inner-banner-wrapper">
        <div class="inner-banner-img">
            <img src="{{imageURL($breadcrumbIMG,'frontend',true,$breadcrumbSize)}}" alt="{{@$breadcrumbIMG->file->name??'breadcrumb.jpg'}}">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 mx-auto">
                    <div class="inner-banner-content text-center">
                        <h2>{{@$banner->title}}</h2>
                        <p>
                            {{@$banner->description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
        <div class="shape-two">
            <img src="{{asset('assets/images/default/breadcrumb_shape.png')}}" alt="breadcrumb-shape.png">
        </div>
        <div class="shape-one">
            <img src="{{asset('assets/images/default/breadcrumb_shape.png')}}" alt="breadcrumb-shape.png">
        </div>
        <ol class="breadcrumb">
            @if(@$breadcrumbs)
                @foreach($breadcrumbs as $text => $url)
                    <li class='breadcrumb-item {{$url? "active" :""}}'>
                        @if($url) 
                                @php
                                if (is_string($url) && app('router')->has($url)) {
                                    $url = route($url);
                                } 
                                @endphp
                            <a href="{{$url}}">{{translate($text)}}</a>
                        @else
                            {{translate($text)}}
                        @endif
                    </li>
                @endforeach
            @else
                <li class="breadcrumb-item"><a href="{{route('home')}}">{{translate('Home')}}</a></li>
            @endif
           
        </ol>
    </nav>
   
</section>