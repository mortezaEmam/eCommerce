<?php

namespace App\Helpers;

trait ImageTrait
{
    public function upload($file, $path)
    {
        if (is_array($file)) {
            $file_address = [];
            foreach ($file as $item) {
                $file_name = generateFileName($item->getClientOriginalName());
                array_push($file_address, $item->storeAs($path, $file_name));
            }
            return $file_address;
        } else {

            $file_name = generateFileName($file->getClientOriginalName());
            return $file->storeAs($path, $file_name);
        }
    }
}
