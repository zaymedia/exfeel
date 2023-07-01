<?php

declare(strict_types=1);

namespace App\Modules\Bot\Command\Webhook\HearsCallback;

use BotMan\BotMan\BotMan;

class HelpCallback
{
    public function handle(BotMan $bot): void
    {
        $commands = [
            '/start - Начать',
            '/help - Показать список команд',
            '/info - Получить информацию',
        ];

        $bot->reply('Доступные команды:' . PHP_EOL . implode(PHP_EOL, $commands));
    }
}
