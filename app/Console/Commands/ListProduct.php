<?php

namespace App\Console\Commands;

use App\Models\Catalog\Product;
use Illuminate\Console\Command;

class ListProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to list product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        /** @var Product[] $products */
        $products = Product::all();
        foreach ($products as $product){
            $this->info("ID: " . $product->getKey() . " Name:" . $product->name);
        }

        return 0;
    }
}
