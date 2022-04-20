<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VerifyCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:cart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to verify cart';

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
        return 0;
    }
}
