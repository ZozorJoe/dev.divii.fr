<?php

namespace App\Http\Controllers\Api\v1\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Http\Resources\File\FileResource;
use App\Services\Uploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class AvatarController extends Controller
{
    /**
     * Upload avatar
     *
     * @param FileRequest $request
     * @param Uploader $uploader
     * @return FileResource|JsonResponse
     */
    public function upload(FileRequest $request, Uploader $uploader)
    {
        $uploadedFile = $request->file('file');
        if($uploadedFile){
            $file = $uploader->upload($uploadedFile, 'avatars');

            return new FileResource($file);
        }

        return response()->json(['success' => false]);
    }
}
