<?php

namespace App\Console\Commands;

use App\Events\User\CreditExpired;
use App\Models\User\Credit;
use Illuminate\Console\Command;

class CleanCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to clean credit';

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
        /** @var Credit[] $models */
        $models = Credit::where('valid_until', '<=', now())
            ->where('value', '>', 0)
            ->get();
        foreach ($models as $model){
            $model->expired_value = $model->value;
            $model->value = 0;
            $model->save();

            event(new CreditExpired($model));
        }

        return 0;
    }
}
