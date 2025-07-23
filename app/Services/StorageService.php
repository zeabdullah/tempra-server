<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageService
{
    /**
     * Stores a given base64 image string into file storage.
     * @return string the URL of the saved image
     */
    public static function storeBase64Image(string $img_base64): string
    {
        $file_extension = explode('/', mime_content_type($img_base64))[1];
        $img_blob = file_get_contents($img_base64);

        $new_file_name = Str::random(16) . ".$file_extension";

        Storage::put($new_file_name, $img_blob);
        return Storage::url($new_file_name);
    }
}
