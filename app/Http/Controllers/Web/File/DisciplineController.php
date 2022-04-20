<?php

namespace App\Http\Controllers\Web\File;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Discipline;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DisciplineController extends Controller
{
    /**
     * Discipline $discipline
     */
    public function picto(Discipline $discipline): BinaryFileResponse
    {
        $image = $discipline->picto;
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

    /**
     * Discipline $discipline
     */
    public function image(Discipline $discipline): BinaryFileResponse
    {
        $image = $discipline->image;
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
}
