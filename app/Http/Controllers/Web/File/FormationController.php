<?php

namespace App\Http\Controllers\Web\File;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Formation;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FormationController extends Controller
{
    /**
     * Formation $formation
     */
    public function image(Formation $formation): BinaryFileResponse
    {
        $image = $formation->image;
        if($image){
            $path = storage_path('app/' . $image->path);
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
     * Formation $formation
     */
    public function picto(Formation $formation): BinaryFileResponse
    {
        $image = $formation->picto;
        if($image){
            $path = storage_path('app/' . $image->path);
        }else{
            /*
            $icon = rand(1, 8);
            $path = public_path("/img/icon/icon-$icon.svg");
            */
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
