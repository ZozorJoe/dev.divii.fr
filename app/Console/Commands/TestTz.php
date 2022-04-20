<?php

namespace App\Console\Commands;

use App\Events\User\CreditExpired;
use App\Models\User\Credit;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TestTz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:tz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to test timezone';

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
        $date = now();
        $this->warn('Date UTC ' . $date->toDayDateTimeString());

        $date->timezone('Indian/Antananarivo');
        $this->info('Date Indian/Antananarivo' . $date->toAtomString());
        dump($date->utc);
        dump($date->format('I'));

        $date->timezone('Europe/Paris');
        $this->info('Date Europe/Paris' . $date->toAtomString());
        dump($date->utc);

        $date->timezone('+02:00');
        $this->info('Date +02:00' . $date->toAtomString());
        dump($date->utc);

        return 0;
    }
}
