<?php

namespace App\Listeners\Shop;

use App\Events\Invoice\InvoiceCreated;
use App\Events\Order\OrderComplete;
use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Shop\Consultation;
use App\Models\Shop\Invoice;
use App\Models\Shop\InvoiceItem;
use App\Models\Shop\Order;

class CreateInvoiceAfterOrderComplete
{

    /**
     * Handle the event.
     *
     * @param OrderComplete $event
     * @return void
     */
    public function handle(OrderComplete $event)
    {
        $order = $event->order;
        if($order){
            $this->createInvoice($order, Product::class);
            $this->createInvoice($order, Formation::class);
            $this->createInvoice($order, Consultation::class);
        }
    }

    /**
     * @param Order $order
     * @param $type
     * @return void
     */
    private function createInvoice(Order $order, $type): void
    {
        $models = $order->items()
            ->where('orderable_type', '=', $type)
            ->get();
        if($models->isNotEmpty()){
            $sub_total = $vat_total = $total = 0;
            foreach ($models as $model){
                $sub_total += $model->sub_total;
                $vat_total += $model->vat_total;
                $total += $model->row_total;
            }

            $reference = $this->getReference($type);

            $invoice = new Invoice();
            $invoice->status = Invoice::STATUS_VALIDATED;
            $invoice->type = Invoice::TYPE_CUSTOMER;
            $invoice->reference = $reference;
            $invoice->order_id = $order->getKey();
            $invoice->user_id = $order->user_id;
            $invoice->currency = $order->currency;
            $invoice->sub_total = $sub_total;
            $invoice->vat_total = $vat_total;
            $invoice->total = $total;
            $invoice->save();

            foreach ($models as $model){
                $item = new InvoiceItem();
                $item->invoiceable_type = $model->orderable_type;
                $item->invoiceable_id = $model->orderable_id;
                $item->quantity = $model->quantity;
                $item->price = $model->price;
                $item->sub_total = $model->sub_total;
                $item->row_total = $model->row_total;
                $item->currency = $model->currency;
                $item->order_item_id = $model->getKey();
                $item->invoice_id = $invoice->getKey();
                $item->save();
            }

            event(new InvoiceCreated($invoice));
        }

    }

    private function getReference($type): string
    {
        $date = date(Invoice::DATE_FORMAT);
        switch (true){
            case $type === Product::class:
                $prefix = "CR$date";
                break;
            case $type === Formation::class:
                $prefix = "CF$date";
                break;
            case $type === Consultation::class:
                $prefix = "CS$date";
                break;
            default:
                $prefix = "CX$date";
                break;
        }

        $invoice = Invoice::where('invoices.reference', 'LIKE', "$prefix %")
            ->orderBy('invoices.reference', 'desc')
            ->first();

        if($invoice){
            $id = explode(' ', $invoice->reference);
            $id = $id[1] ?? 0;
        }else{
            $id = 0;
        }

        do{
            $id++;
            $reference = str_pad($id, Invoice::STR_PAD_LENGTH, Invoice::STR_PAD_STRING, STR_PAD_LEFT);
            $exists = Invoice::where('invoices.reference', '=', "$prefix $reference")
                ->exists();
        }while($exists);

        return "$prefix $reference";
    }
}
