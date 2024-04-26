{{--Used on the index page (so shows a small summary--}}
{{--See the guide on binshops.com for how to copy these files to your /resources/views/ directory--}}

<div class="col-md-12" style="margin-bottom: 20px;">
    <div class="blog-item">

        <div class="blog-inner-item">
            <h3 class=''><a href='{{$post->url($locale, $routeWithoutLocale)}}'>{{$post->title}}</a></h3>
            <h5 class=''>{{$post->subtitle}}</h5>

            <div class="post-details-bottom">
                <span class="light-text">Authored by: </span> {{$post->post->author->user_name}} <span class="light-text">Posted at: </span> {{date('d M Y ', strtotime($post->post->posted_at))}}
            </div>
            <!-- <div class='text-center'>
                <a href="{{$post->url($locale, $routeWithoutLocale)}}" class="btn btn-primary">View Post</a>
            </div> -->
        </div>
    </div>

</div>
