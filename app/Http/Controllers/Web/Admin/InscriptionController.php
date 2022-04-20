<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Web\WebController;
use App\Models\User;
use App\Models\User\Customer;
use Illuminate\Http\Request;

class InscriptionController extends WebController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function download(Request $request)
    {
        $builder = Customer::query();
        $builder->select('users.email', 'users.first_name', 'users.last_name');
        $builder->where('users.channel', '=', User::CHANNEL_LAUNCH);
        $models = $builder->get();

        $columns = array('Email', 'Prénom', 'Nom');
        $callback = function() use($models, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ";");

            foreach ($models as $model) {
                fputcsv($file, array($model->email), ";");
            }

            fclose($file);
        };

        $filename = "inscriptions-" . date('Y-m-d') . ".csv";

        $headers = array(
            "Content-type"        => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        return response()->stream($callback, 200, $headers);
    }
}
