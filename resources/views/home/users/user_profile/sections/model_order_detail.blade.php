<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" style="direction: rtl;">
        <form action="#">
            <div class="table-content table-responsive cart-table-content">
                <table>
                    <thead>
                    <tr>
                        <th> تصویر محصول </th>
                        <th> نام محصول </th>
                        <th> فی </th>
                        <th> تعداد </th>
                        <th> قیمت کل </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order_details as $item)
                        <tr>
                            <td class="product-thumbnail">
                                <a href="{{ route('home.products.show' , ['product' => $item->product->slug]) }}">
                                    <img width="70" src="{{Storage::url($item->product->primary_image)}}" alt="">
                                </a>
                            </td>
                            <td class="product-name"><a href="{{ route('home.products.show' , ['product' => $item->product]) }}"> {{ $item->product->name }} </a></td>
                            <td class="product-price-cart">
                                <span class="amount">{{ number_format($item->price) }}تومان</span>
                            </td>
                            <td class="product-quantity">
                                {{ $item->quantity }}
                            </td>
                            <td class="product-subtotal">{{ number_format($item->subtotal) }}تومان</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
