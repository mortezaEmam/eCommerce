<div class="col-lg-9 col-md-8">
    <div class="myaccount-content">
        <h3>سفارشات</h3>
        <div class="myaccount-table table-responsive text-center">
            @if ($orders->isEmpty())
                <div class="alert alert-danger">
                    لیست سفارشات شما خالی می باشد
                </div>
            @else
                <table class="table table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th> سفارش</th>
                        <th> تاریخ</th>
                        <th> وضعیت</th>
                        <th> جمع کل</th>
                        <th> عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td> {{ verta($order->created_at)->format('%d %B، %Y') }}
                            </td>
                            <td>{{ $order->status }}</td>
                            <td>
                                {{ number_format($order->paying_amount) }}
                                تومان
                            </td>
                            <td>
                                <a data-order_id="{{$order->id}}"
                                   data-target="#ordersDetiles"
                                   data-toggle="modal"
                                   class="check-btn sqr-btn show-detail-order">
                                    نمایش جزئیات
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-5">
                    {{$orders->render('home.section.pagination')}}
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Modal Order -->
<div class="modal fade "  id="ordersDetiles" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
@section('page_variable')
    <script>
        window.js_vars={
            url_get_show_order_detail:'{{route('home.profile.get_show_order_detail')}}',
        }
    </script>
@endsection
@section('scripts')
    <script>
        $(document).on('click','.show-detail-order',function (e){
            e.preventDefault();
            let order_id = $(this).data('order_id'),
             url= "{{route('home.profile.get_show_order_detail')}}";
            $.ajax({
                url: url,
                type: "POST",
                data:{
                    order_id:order_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result){
                   $('.modal-body').html(result.view);

                }
            })
            console.log('btn');
        })
    </script>
@endsection
