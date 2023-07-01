<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class HelpCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper
    ) {
    }

    public static function getPattern(): array
    {
        return ['/help'];
    }

    public function handle(): void
    {
        $commands = [
            '/start',
            '/help',
            '/balance',
            '/photo',
        ];

        $keyboard = Keyboard::create();
        $keyboard->addRow(
            KeyboardButton::create('Ссылка')->url('https://example.com/button1'),
            KeyboardButton::create('Кнопка')->callbackData('ttt')
        );

        $this->bot->reply('Доступные команды:' . PHP_EOL . implode(PHP_EOL, $commands), $keyboard->toArray());
    }
}
