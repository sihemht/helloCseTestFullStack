<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function upload(UploadedFile $file, string $path)
    {
        //Store image in storage/app/public/path with unique name
        return $file->store($path, 'public');
    }

    //Delete image if exist
    public function delete(string $path)
    {
        if ($path && file_exists(storage_path('app/public/' . $path))) {
            Storage::delete('public/' . $path);
        }
    }
}
