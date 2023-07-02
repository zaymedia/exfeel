<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;

class SubscribersCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper
    ) {
    }

    public function __invoke(): void
    {
        $this->bot->typesAndWaits(2);

        $this->bot->reply('subscribers');
    }

    public static function getPattern(): array
    {
        return ['/subscribers'];
    }
}
