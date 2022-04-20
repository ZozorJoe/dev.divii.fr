<?php

namespace App\Http\Controllers\Web\File;

use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    /**
     * User $user
     */
    public function image(User $user): BinaryFileResponse
    {
        $avatar = $user->avatar;
        if($avatar){
            $path = storage_path('app/' . $avatar->path);
        }else{
            $path = public_path('/img/image.svg');
        }

        if(!is_file($path)){
            abort(404);
        }

        $fileType = \File::mimeType($path);
        $headers = [
            'Content-Disposition' => 'inline;filename="image.jpg"',
            'Content-Type' => $fileType,
        ];

        return response()->file($path, $headers);
    }

    /**
     * User $user
     */
    public function picto(User $user): BinaryFileResponse
    {
        $picto = $user->picto;
        if($picto){
            $path = storage_path('app/' . $picto->path);
        }else{
            $path = public_path('/img/image.svg');
        }

        if(!is_file($path)){
            abort(404);
        }

        $fileType = \File::mimeType($path);
        $headers = [
            'Content-Disposition' => 'inline;filename="image.jpg"',
            'Content-Type' => $fileType,
        ];

        return response()->file($path, $headers);
    }
}
