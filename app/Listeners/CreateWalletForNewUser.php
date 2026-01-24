<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Wallet;

class CreateWalletForNewUser
{
    public function handle(Registered $event): void
    {
        Wallet::firstOrCreate(
            ['user_id' => $event->user->id],
            ['balance' => 0]
        );
    }
}
