<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, softDeletes;

    public function fileable()
    {
        return $this->morphTo();
    }
    public static function upload($primaryImage, $images ,$object)
    {
        $fileNamePrimaryImage = generateFileName($primaryImage->getClientOriginalName());
        $mime_type =  $primaryImage->getClientMimeType();
        $primaryImage->storeAs(env('PRODUCT_IMAGES_UPLOAD_PATH'), $fileNamePrimaryImage);

        $file = new File();
        $file->name = $fileNamePrimaryImage;
        $file->path = env('PRODUCT_IMAGES_UPLOAD_PATH');
        $file->mime_type = $mime_type;
        $object->files()->save($file);
        $fileNameImages = [];
        foreach ($images as $image) {
            $fileNameImage = generateFileName($image->getClientOriginalName());

            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);

            array_push($fileNameImages, $fileNameImage);
        }

        return ['fileNamePrimaryImage' => $fileNamePrimaryImage, 'fileNameImages' => $fileNameImages];
    }
}
