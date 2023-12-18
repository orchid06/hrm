

<meta name="description" content='{{Arr::get($meta_data,"meta_description","")}}' />
<meta property="og:site_name" content='{{@site_settings("user_site_name")}}' />
<meta name='keywords' content='{{implode(",",Arr::get($meta_data,"meta_keywords",""))}}'>
<meta name='copyright' content='{{@site_settings("copy_right_text")}}'>
<meta property="og:locale" content="{{(app()->getLocale()).'_'.ucwords(app()->getLocale())}}" />
<meta property="og:title" content='{{site_settings("user_site_name")}}' />
<meta property="og:description" content='{{Arr::get($meta_data,"meta_description","")}}' />
<meta property="og:type" content='{{Arr::get($meta_data,"og_type","")}}' />
<meta property="og:image" content='{{Arr::get($meta_data,"og_image","")}}' />
<meta property="og:image:type" content='{{Arr::get($meta_data,"og_image_type","")}}'>
<meta property="og:image:width" content='{{Arr::get($meta_data,"og_image_width","")}}'>
<meta property="og:image:height" content='{{Arr::get($meta_data,"og_image_height","")}}'>
<meta property="og:url" content="{{url()->current()}}" />
<meta name='og:email' content='{{@site_settings("email")}}'>
<meta name='og:phone_number' content='{{@site_settings("phone")}}'>
<meta name="twitter:title" content='{{Arr::get($meta_data,"title","")}}' />
<meta name="twitter:description" content='{{Arr::get($meta_data,"meta_description","")}}' />
<meta name="twitter:card" content='{{Arr::get($meta_data,"twitter_card","summary")}}' />
<meta name="twitter:image" content='{{Arr::get($meta_data,"og_image","")}}' />
<link rel="canonical" href="{{url()->current()}}" />
<meta name="robots" content='{{Arr::get($meta_data,"robots","follow")}}' />
<meta property="base_url" content="{{url('/')}}"> 





