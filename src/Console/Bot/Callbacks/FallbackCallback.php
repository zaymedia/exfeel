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

    public function __invoke(): void
    {
        $this->bot->typesAndWaits($this->botHelper->getTypingSeconds());

        $message = 'Sorry, I did not understand these commands.' . PHP_EOL .
            $this->bot->getMessage()->getText() . PHP_EOL .
            json_encode($this->bot->getMessage()->getPayload());

        $this->bot->reply($message);
    }
}
