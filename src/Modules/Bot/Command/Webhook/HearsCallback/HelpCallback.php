<?php

declare(strict_types=1);

namespace App\Modules\Bot\Command\Webhook\HearsCallback;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class HelpCallback
{
    public function handle(BotMan $bot): void
    {
        $commands = [
            '/start - Начать',
            '/help - Показать список команд',
            '/info - Получить информацию',
        ];

        $keyboard = Keyboard::create();
        $keyboard->addRow(
            KeyboardButton::create('Подписки')->url('https://example.com/button1'),
            KeyboardButton::create('Тарифы')->url('https://example.com/button1')
        );

        $bot->reply('Доступные команды:' . PHP_EOL . implode(PHP_EOL, $commands), $keyboard->toArray());
    }
}
