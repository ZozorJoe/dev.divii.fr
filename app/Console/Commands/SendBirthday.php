<?php

namespace App\Console\Commands;

use App\Facades\Coupons;
use App\Models\Sale\Coupon;
use App\Models\User;
use App\Notifications\User\Birthday;
use Illuminate\Console\Command;

class SendBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send birthday notification';

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
        /** @var User[] $users */
        $users = User::whereNotNull('users.birthday')
            ->whereDate('users.birthday', '=', now())
            ->get();
        foreach ($users as $user){
            /** @var Coupon[] $coupons */
            $coupons = Coupons::create();
            $user->notify(new Birthday($coupons[0]));
        }
        return 0;
    }
}
