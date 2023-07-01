<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Components\Callback\Callback;
use BotMan\BotMan\BotMan;

class BalanceCallback implements Callback
{
    public static function getMethod(): string
    {
        return self::class . '@handle';
    }

    public static function getPattern(): array
    {
        return ['/balance', '/bal'];
    }

    public function handle(BotMan $bot): void
    {
        $bot->reply('Your balance: ');
    }
}
