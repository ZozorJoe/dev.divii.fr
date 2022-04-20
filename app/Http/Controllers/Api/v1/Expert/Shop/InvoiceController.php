<?php

namespace App\Http\Controllers\Api\v1\Expert\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Expert\Shop\InvoiceCollection;
use App\Http\Resources\Expert\Shop\InvoiceResource;
use App\Models\Shop\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return InvoiceCollection
     */
    public function index(Request $request, Invoice $invoice): InvoiceCollection
    {
        /** @var User $user */
        $user = $request->user();

        $builder = $user->invoices();

        $builder->latest();

        $builder->where('type', '=', Invoice::TYPE_EXPERT);

        $this->with($request, $invoice, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('name', 'LIKE', "%$search%");
                $builder->orWhere('description', 'LIKE', "%$search%");
            });
        }

        $status = (int) $request->get('status', 0);
        switch ($status){
            case 1:
                $builder->where('invoices.status', '=', Invoice::STATUS_PING);
                break;
            default:
                $builder->where('invoices.status', '=', Invoice::STATUS_VALIDATED);
                break;
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new InvoiceCollection($models, $perPage > 0);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return InvoiceResource
     */
    public function show(Request $request, Invoice $invoice): InvoiceResource
    {
        $this->with($request, $invoice);

        $invoice->load(['items.invoiceable', 'items.orderItem']);

        return new InvoiceResource($invoice);
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param Invoice $invoice
     * @param string $status
     * @return JsonResponse
     */
    public function changeStatus(Invoice $invoice, string $status): JsonResponse
    {
        switch ($status){
            case Invoice::STATUS_REFUSED:
            case Invoice::STATUS_VALIDATED:
                $invoice->status = $status;
                return response()->json([
                    'success' => $invoice->save()
                ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
