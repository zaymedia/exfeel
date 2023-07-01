<?php

declare(strict_types=1);

namespace App\Console\Bot\Webhook\Callbacks;

use BotMan\BotMan\BotMan;

class BalanceCallback
{
    public function handle(BotMan $bot): void
    {
        $bot->reply('Your balance: ');
    }
}
