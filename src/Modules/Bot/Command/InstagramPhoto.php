<?php

declare(strict_types=1);

namespace App\Modules\Bot\Command;

use BotMan\BotMan\BotMan;

class InstagramPhoto
{
    public function handleFoo(BotMan $bot): void
    {
        $bot->reply('Hello World');
    }
}
