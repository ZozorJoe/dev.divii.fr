<?php

namespace App\Http\Controllers\Web\Account;

use App\Http\Controllers\Web\WebController;
use App\Models\Shop\Invoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends WebController
{
    /**
     * @param Request $request
     * @param Invoice $invoice
     * @return mixed
     */
    public function show(Request $request, Invoice $invoice)
    {
        /** @var User $user */
        $user = $request->user();
        if(!$user->isAdministrator() && $user->getKey() !== $invoice->user_id){
            abort(403);
        }

        /*
        $view = view('account.invoice')
            ->with('model', $invoice)
            ->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->download('invoice-' . $invoice->getKey() . '.pdf');
        */

        return view('account.invoice')
            ->with('model', $invoice);

    }

    /**
     * @return Response
     *
    public function show(Request $request, Invoice $invoice): Response
    {
        $pdf = PDF::loadHTML('<h1>Test</h1>');
        return $pdf->download('invoice.pdf');
    }*/
}
