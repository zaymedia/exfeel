<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;

class FallbackCallback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper
    ) {
    }

    public function handle(): void
    {
        $this->bot->reply('Sorry, I did not understand these commands.');
        $this->bot->reply($this->bot->getMessage()->getText());

        $this->bot->reply(json_encode($this->bot->getMessage()->getPayload()));
    }
}
