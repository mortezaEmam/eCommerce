<?php

use App\Models\File;
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
