<?php

namespace App\Helpers;

use App\Models\File;

trait uploader_image
{
    function address_upload_image($product_primary_image = false, $product_images = false, $pic_avatar = false)
    {

        switch (true) {
            case $product_primary_image == true:
                return 'public/product/upload/product_primary_image';
            case $product_images == true:
                return 'public/product/upload/product_images';

            case $pic_avatar == true:
                return 'public/user/upload/pic_avatar';
            default:
                alert(403);
        }


    }

    function upload($image, $path , $object = null)
    {
        $file_name = generateFileName($image->getClientOriginalName());
        $mime_type = $image->getClientMimeType();
        $address_file = $image->storeAs($path, $file_name);

        if ($object)
        {
            $file = new File();
            $file->name = $file_name;
            $file->path = $path;
            $file->mime_type = $mime_type;
            $object->files()->save($file);
        }
        else
        {
            return $address_file;
        }
    }

}
