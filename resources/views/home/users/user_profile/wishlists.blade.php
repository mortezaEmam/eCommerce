<!-- Single Tab Content Start -->
<div class="col-lg-9 col-md-8">
    <div class="tab-content">
        <div class="myaccount-content">
            <h3> لیست علاقه مندی ها </h3>
            <form class="mt-3" action="#">
                <div class="table-content table-responsive cart-table-content">
                    <table>
                        <thead>
                        <tr>
                            <th> تصویر محصول</th>
                            <th> نام محصول</th>
                            <th> حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($wishlists->isEmpty())
                            <div class="alert alert-danger">
                                لیست علاقه مندی های شما خالی می باشد.
                            </div>
                        @else
                            @foreach($wishlists as $wishlist)
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img width="100" height="100"
                                                         src="{{Storage::Url($wishlist->product->primary_image)}}"
                                                         alt=""></a>
                                    </td>
                                    <td class="product-name"><a
                                            href="{{route('admin.products.show' , ['product' => $wishlist->product->slug])}}">{{$wishlist->product->name}}</a>
                                    </td>
                                    <td class="product-name">
                                        <a href="{{route('home.wishlist.remove' ,['product' => $wishlist->product->id])}}">
                                            <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Single Tab Content End -->
