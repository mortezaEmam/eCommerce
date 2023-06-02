<div id="comments" class="ratting-form-wrapper text-right">
    <span> نوشتن دیدگاه </span>
    <div class="my-3" id="dataReadonlyReview"
         data-rating-stars="5"
         data-rating-value="0"
         data-rating-input="#rateInput">
    </div>

    <div class="ratting-form">
        <form action="{{route('home.comments.store', ['product' => $product->id])}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="rating-form-style mb-20">
                        <label> متن دیدگاه : </label>
                        <textarea name="text"></textarea>
                    </div>
                </div>
                <input id="rateInput" type="hidden" name="rate" value="0">
                <div class="col-lg-12">
                    <div class="form-submit">
                        <input type="submit" value="ارسال">
                    </div>
                </div>
                <div class="mt-4">
                    @include('home.section.errors')
                </div>
            </div>
        </form>
    </div>

</div>
