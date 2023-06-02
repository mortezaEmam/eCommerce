@foreach($approvedComments->get() as $coment)
    <div class="single-review">
        <div class="review-img">
            <img src="{{$coment->user->avatar == null ? asset('images/home/user.png') : $coment->user->avatar}}" alt="">
        </div>
        <div class="review-content text-right w-100" >
            <p class="text-right" style="overflow-wrap: anywhere">
                {!! $coment->text !!}
            </p>
            <div class="review-top-wrap">
                <div class="review-name">
                    <h4> {{$coment->user->name?:'کاربر گرامی'}} </h4>
                </div>
                <div id="dataReadonlyReview"
                     data-rating-stars="5"
                     data-rating-readonly="true"
                     data-rating-value="{{ceil($product->avgProductRateOfUser($coment->user))}}">
                </div>
            </div>
        </div>
    </div>
@endforeach
