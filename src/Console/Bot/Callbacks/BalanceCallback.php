<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;

class BalanceCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper
    ) {
    }

    public static function getPattern(): array
    {
        return ['/balance', '/bal'];
    }

    public function handle(): void
    {
        $user = $this->botHelper->getOrRegisterUser($this->bot);

        $this->bot->reply('Your balance: ' . $user->getBalance());
    }
}
