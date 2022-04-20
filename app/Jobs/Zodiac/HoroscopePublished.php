<?php

namespace App\Jobs\Zodiac;

use App\Models\User;
use App\Models\Zodiac\Horoscope;
use App\Notifications\Zodiac\HoroscopeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HoroscopePublished implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var Horoscope
     */
    protected $horoscope;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Horoscope $horoscope)
    {
        $this->horoscope = $horoscope;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var User[] $users */
        $users = User::whereNotNull('birthday')
            ->whereDoesntHave('horoscopes', function (Builder $query) {
                $query->where('horoscopes.id', '=', $this->horoscope->getKey());
            })
            ->get();
        foreach ($users as $user){
            $user->notify(new HoroscopeNotification($this->horoscope));
            $user->horoscopes()->attach($this->horoscope->getKey());
        }
    }
}
