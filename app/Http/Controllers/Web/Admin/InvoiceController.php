<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Web\WebController;
use App\Models\Shop\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use ZipArchive;

class InvoiceController extends WebController
{
    /**
     * @param Request $request
     * @param $type
     * @return mixed
     */
    public function download(Request $request, $type)
    {
        $files = [];
        for($i = 0; $i < 10; $i++){
            $file = storage_path("app/invoice$i.pdf");
            $pdf = PDF::loadHTML("<h1>Test $i</h1>");
            $pdf->save($file);
            $files[] = $file;
        }

        $date = date('Y-m-d-H-i-s');
        $zipFile = storage_path("app/invoice-$date.zip");
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE)
        {
            // Add files to the zip file
            foreach ($files as $file){
                info($file);
                $zip->addFile($file, basename($file));
            }

            // All files are added, so close the zip file.
            $zip->close();
        }

        $headers = array(
            'Content-Type: application/zip',
        );

        return response()->download($zipFile, "invoices-$type.zip", $headers);
    }
}
