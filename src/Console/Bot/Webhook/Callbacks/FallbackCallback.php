<?php

declare(strict_types=1);

namespace App\Console\Bot\Webhook\Callbacks;

use BotMan\BotMan\BotMan;

class FallbackCallback
{
    public function handle(BotMan $bot): void
    {
        $bot->reply('Sorry, I did not understand these commands.');
        $bot->reply($bot->getMessage()->getText());

        $bot->reply(json_encode($bot->getMessage()->getPayload()));
    }
}
