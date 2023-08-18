<?php

namespace App\Helper;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileManager {

    public static function generateFilename(UploadedFile $file, string $folder): string
    {
        $filename = $file->getClientOriginalName();
        
        while(Storage::disk('public')->exists("$folder/$filename"))
        {
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $filename = $name . "_copy." . $ext;
        }

        return $filename;
    }

}