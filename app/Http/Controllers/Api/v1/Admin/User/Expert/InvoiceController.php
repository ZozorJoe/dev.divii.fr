<?php

namespace App\Http\Controllers\Api\v1\Admin\User\Expert;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Shop\InvoiceRequest;
use App\Http\Resources\Admin\Shop\InvoiceCollection;
use App\Http\Resources\Admin\Shop\InvoiceResource;
use App\Models\Shop\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Invoice::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return InvoiceCollection
     */
    public function index(Request $request, Invoice $invoice): InvoiceCollection
    {
        $builder = Invoice::query();

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

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new InvoiceCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceRequest $request
     * @param Invoice $invoice
     * @return InvoiceResource|JsonResponse
     */
    public function store(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice = $request->handle($invoice);
        if($invoice){
            return $this->show($request, $invoice);
        }

        return response()->json([
            'success' => false,
        ]);
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
     * Update the specified resource in storage.
     *
     * @param InvoiceRequest $request
     * @param Invoice $invoice
     * @return InvoiceResource|JsonResponse
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice = $request->handle($invoice);
        if($invoice){
            return $this->show($request, $invoice);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        return response()->json([
            'success' => $invoice->delete(),
        ]);
    }

    /**
     * Mass delete the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function massDelete(Request $request): JsonResponse
    {
        $invoices = $request->input('invoices');
        if (!empty($invoices)){
            if ($count = Invoice::destroy($invoices)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
