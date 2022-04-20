<?php

namespace App\Http\Controllers\Api\v1\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Http\Resources\File\FileResource;
use App\Services\Uploader;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{
    /**
     * Upload file
     *
     * @param FileRequest $request
     * @param Uploader $uploader
     * @return FileResource|JsonResponse
     */
    public function upload(FileRequest $request, Uploader $uploader)
    {
        $uploadedFile = $request->file('file');
        if($uploadedFile){
            $file = $uploader->upload($uploadedFile, 'files');

            return new FileResource($file);
        }

        return response()->json(['success' => false]);
    }
}
