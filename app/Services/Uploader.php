<?php

namespace App\Services;

use App\Models\File\File;
use Illuminate\Http\UploadedFile;

class Uploader
{
    public function upload(UploadedFile $file, $dir)
    {
        $name = $file->getClientOriginalName();
        $path = $file->storeAs($dir, md5(time()).'.'.$file->extension());
        return File::create([
            'name' => $name,
            'path' => $path,
        ]);
    }
}
