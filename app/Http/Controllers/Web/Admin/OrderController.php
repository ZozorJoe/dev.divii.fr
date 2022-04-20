<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Web\WebController;
use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderController extends WebController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function download(Request $request)
    {
        $start = now()->subMonth()->startOfMonth();
        $end = now()->subMonth()->endOfMonth();

        $builder = Order::query();
        $builder->where(function (Builder $builder){
            $builder->orWhere('orders.status', '=', Order::STATUS_VALIDATED);
            $builder->orWhere('orders.status', '=', Order::STATUS_COMPLETE);
        });
        $builder->where('orders.created_at', '>=', $start);
        $builder->where('orders.created_at', '<=', $end);
        $builder->with('user');

        /** @var Order[] $models */
        $models = $builder->get();

        $columns = array('Prénom', 'Nom', 'Date', 'Montant HT', 'Montant TTC', 'Montant TVA');
        $callback = function() use($models, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ";");

            foreach ($models as $model) {
                $data = [
                    $model->user ? $model->user->first_name : '',
                    $model->user ? $model->user->last_name : '',
                    $model->created_at->toAtomString(),
                    $model->sub_total . " €",
                    $model->total . " €",
                    $model->vat_total . " €",
                ];
                fputcsv($file, $data, ";");
            }

            fclose($file);
        };

        $filename = "orders-" . $start->format("Y-m") . ".csv";

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
