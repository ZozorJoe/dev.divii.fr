<?php

namespace App\Console\Commands;

use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
use App\Models\Shop\Invoice;
use App\Models\Shop\InvoiceItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class InvoiceGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate invoice';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info("INIT");
        $date = now();
        if($date->day < 16){
            // [16-30]
            $start = now()->subMonth()->startOfMonth()->setDay(16);
            $end = now()->subMonth()->endOfMonth();
        }else{
            // [1-15]
            $start = now()->startOfMonth();
            $end = now()->setDay(15);
        }
        $this->info("Export invoice [{$start->toDateString()},{$end->toDateString()}]");

        /** @var User[] $experts */
        $experts = User::whereHas('rooms', function (Builder $query) use ($end, $start) {
            $query->where('rooms.status', '=', Room::STATUS_VALIDATED);
            $query->whereDate('rooms.start_at', '>=', $start);
            $query->whereDate('rooms.start_at', '<=', $end);
            $query->whereColumn('rooms.user_id', '=', 'users.id');
        })->get();

        foreach ($experts as $expert){
            $this->createInvoice(Formation::class, $expert, $start, $end);
            $this->createInvoice(Consultation::class, $expert, $start, $end);
        }

        $this->error("---> DONE");

        return 0;
    }

    private function getReference(Carbon $date, $type): string
    {
        $date = $date->format(Invoice::DATE_FORMAT);
        switch (true){
            case $type === Formation::class:
                $prefix = "FO$date";
                break;
            case $type === Consultation::class:
                $prefix = "CO$date";
                break;
            default:
                $prefix = "EX$date";
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

    private function createInvoice($type, User $expert, Carbon $start, Carbon $end)
    {
        $builder = Room::query();
        $builder->where('rooms.model_type', '=', $type);
        $builder->where('rooms.user_id', '=', $expert->getKey());
        $builder->where('rooms.status', '=', Room::STATUS_VALIDATED);
        $builder->whereDate('rooms.start_at', '>=', $start);
        $builder->whereDate('rooms.start_at', '<=', $end);
        $exists = $builder->exists();
        if($exists){
            /** @var Room[] $rooms */
            $rooms = $builder->get();

            // Calculate duration
            $vat_total = 0;
            $sub_total = 0;
            foreach ($rooms as $room){
                $sub_total += $this->getAmount($room, $type);
            }
            $total = $sub_total + $vat_total;

            $reference = $this->getReference($start, $type);

            $invoice = new Invoice();
            $invoice->reference = $reference;
            $invoice->status = Invoice::STATUS_PING;
            $invoice->type = Invoice::TYPE_EXPERT;
            $invoice->user_id = $expert->getKey();
            $invoice->order_id = null;
            $invoice->currency = 'EUR';
            $invoice->sub_total = $sub_total;
            $invoice->vat_total = $vat_total;
            $invoice->total = $total;
            $invoice->save();

            foreach ($rooms as $room){
                $_sub_total = $this->getAmount($room, $type);

                $item = new InvoiceItem();
                $item->invoiceable_type = Room::class;
                $item->invoiceable_id = $room->getKey();
                $item->quantity = 1;
                $item->price = $_sub_total;
                $item->sub_total = $_sub_total;
                $item->row_total = $_sub_total;
                $item->currency = 'EUR';
                $item->order_item_id = null;
                $item->invoice_id = $invoice->getKey();
                $item->save();

                $room->status = Room::STATUS_INVOICED;
                $room->save();
            }
        }
    }

    private function getAmount(Room $room, $type)
    {
        $duration = $room->start_at->diffInMinutes($room->end_at);
        if($type === Formation::class){
            return 80 * ($duration / 60);
        }else{
            switch (true){
                case $duration <= 15: return 12;
                case $duration <= 30: return 24;
                case $duration <= 45: return 35;
                case $duration <= 60: return 45;
                default:
                    $value = $duration - 60;
                    $count = ceil($value / 15);
                    return 45 + (10 * $count);
            }
        }
    }
}
