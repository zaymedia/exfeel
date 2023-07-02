<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class StartCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
    ) {
    }

    public function __invoke(): void
    {
        if ($this->botHelper->isNewUser()) {
            $this->bot->reply('Даров, новичок!');
        } else {
            $this->bot->reply('Дарова, старичок!');
        }

        $message = 'invoke! ' . $this->botHelper->translate('start');

        $this->bot->reply($message);
    }

    public static function getPattern(): array
    {
        return ['/start'];
    }

    private function keyboard(): array
    {
        $keyboard = Keyboard::create(Keyboard::TYPE_KEYBOARD);

        $keyboard->resizeKeyboard();

        $keyboard->addRow(
            KeyboardButton::create('Подписки'),
            KeyboardButton::create('Тарифы')
        );
        $keyboard->addRow(
            KeyboardButton::create('Настройки'),
            KeyboardButton::create('Поддержка')
        );

        return $keyboard->toArray();
    }
}
