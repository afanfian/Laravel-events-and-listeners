<?php

namespace App\Listeners;

use App\Events\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreUserLoginHistory implements ShouldQueue
{
    public $connection = 'sqs';
    public $queue = 'listeners';
    public $delay = 10;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LoginHistory  $event
     * @return void
     */
    public function handle(LoginHistory $event)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $userinfo = $event->user;

        $saveHistory = DB::table('login_history')->insert(
            [
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp
            ]
        );
        return $saveHistory;
    }

    public function viaQueue()
    {
        return 'listeners';
    }

    public function shouldQueue(LoginHistory $event)
    {
        return true;
    }

    public $tries = 2;

    public function failed(OrderShip $event, $exception)
    {
        // logic yang ingin dijalankan ketika gagal
    }

    public function retryUntil()
    {
        return now()->addSeconds(5);
    }
}
