<!-- Single Tab Content Start -->
<div class="col-lg-9 col-md-8">
    <div class="tab-content">
        <div class="myaccount-content">
            <h3> نظرات </h3>
            <div class="review-wrapper">
                @if($comments->isEmpty())
                    <div class="alert alert-danger">
                        لیست نظرات شما خالی می باشد.
                    </div>
                @else
                @foreach($comments as $comment)
                    <div class="single-review">
                        <div class="review-img">
                            <img src="{{$comment->user->avatar == null ? asset('images/home/user.png') : $comment->user->avatar}}" alt="{{$comment->user->name}}">
                        </div>
                        <div class="review-content w-100 text-right">
                            <p class="text-right" style="overflow-wrap: anywhere">{!!$comment->text !!}</p>
                            <div class="review-top-wrap">
                                <div class="review-name d-flex align-items-center">
                                    <h4>
                                        برای محصول :
                                    </h4>
                                    <a class="mr-1" href="{{route('home.products.show' , ['product' => $comment->product->slug])}}" style="color:#ff3535;">{{$comment->product->name}}</a>
                                </div>
                                <div>
                                    در تاریخ :
                                    {{verta($comment->created_at)->format('%d %B %Y')}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Single Tab Content End -->

