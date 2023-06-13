<?php

use App\Models\Coupon;
use App\Models\File;
use App\Models\Order;
use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;


function generateFileName($name)
{
    $year = Carbon::now()->year;
    $month = Carbon::now()->month;
    $day = Carbon::now()->day;
    $hour = Carbon::now()->hour;
    $minute = Carbon::now()->minute;
    $second = Carbon::now()->second;
    $microsecond = Carbon::now()->microsecond;
    return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
}

function convertShamsiToGregorianDate($date)
{
    if ($date == null) {
        return null;
    }
    $pattern = "/[-\s]/";
    $shamsiDateSplit = preg_split($pattern, $date);
    $time = explode(':', $shamsiDateSplit[3]);

    $arrayGergorianDate = CalendarUtils::toGregorianDate($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2])->setTime($time[0], $time[1], $time[2]);
    return $arrayGergorianDate;
}
function convertGregorianToShamsiDate($date)
{
    if ($date == null) {
        return null;
    }
    $pattern = "/[-\s]/";
    $shamsiDateSplit = preg_split($pattern, $date);
    $arrayGergorianDate = CalendarUtils::toJalali($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);
    return implode('-',$arrayGergorianDate).' '.$shamsiDateSplit[3];
}

function uploadFile($object, $image, $path){
    $file_name = generateFileName($image->getClientOriginalName());
    $mime_type = $image->getClientMimeType();
    $image->storeAs($path, $file_name);
    $file = new File();
    $file->name = $file_name;
    $file->path = $path;
    $file->mime_type = $mime_type;
    $object->files()->save($file);
}
function upload_Primary_image_product($primaryImage, $path)
{
    $file_name = generateFileName($primaryImage->getClientOriginalName());
    $primaryImage->storeAs($path, $file_name);

    return $path . $file_name;
}
function getPriceTotalAmountPercentProducts()
{
    $cartTotalSaleAmount = 0;
    foreach (Cart::getContent() as $item)
    {
        if($item->attributes->is_sale)
        {
            $cartTotalSaleAmount += $item->quantity * ($item->attributes->price - $item->attributes->sale_price);
        }
    }
    return $cartTotalSaleAmount;
}
function getDeliveryAmountProduct()
{
    $get_delivery_amount_product = 0;
    foreach (Cart::getContent() as $item)
    {
        $get_delivery_amount_product += $item->associatedModel->delivery_amount;
    }
    return $get_delivery_amount_product;
}
function SetCheckCoupon($code)
{
    $coupon = Coupon::query()->where('code',$code)->where('expired_at','>',Carbon::now())->first();

    if ($coupon == null) {
        session()->forget('coupon');
        return ['error' => 'کد تخفیف وارد شده وجود ندارد'];
    }
    if(Order::query()->where('coupon_id',$coupon->id)->where('user_id',auth()->id())->where('payment_status', 1)->exists())
    {
        session()->forget('coupon');
        return ['error' => 'کد تخفیف وارد شده قبلا استفاده شده است'];
    }
    if ($coupon->getRawOriginal('type') == 'amount') {
        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $coupon->amount]);
    } else {
        $total = Cart::getTotal();

        $amount = (($total * $coupon->percentage) / 100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (($total * $coupon->percentage) / 100);

        session()->put('coupon', ['id' => $coupon->id, 'code' => $coupon->code, 'amount' => $amount]);
    }

    return ['success' => 'کد تخفیف برای شما ثبت شد'];

}
function cartTotalAmount()
{
    if (session()->has('coupon')) {
        if (session()->get('coupon.amount') > (\Cart::getTotal() + getDeliveryAmountProduct())) {
            return 0;
        } else {
            return (\Cart::getTotal() + getDeliveryAmountProduct()) - session()->get('coupon.amount');
        }
    } else {
        return \Cart::getTotal() + getDeliveryAmountProduct();
    }
}
