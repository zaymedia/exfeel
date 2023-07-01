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
        private readonly BotMan $botMan,
        private readonly BotHelper $botHelper
    ) {
    }

    public static function getMethod(): string
    {
        return self::class . '@handle';
    }

    public static function getPattern(): array
    {
        return ['/start'];
    }

    public function handle(BotMan $bot): void
    {
        $this->botHelper->getOrRegisterUser($bot);

        if ($this->botHelper->isNewUser()) {
            $bot->reply('Даров, новичок!');
        } else {
            $bot->reply('Дарова, старичок!');
        }

        // $bot->reply(json_encode($info));
        $bot->reply('Language: ' . $this->botHelper->getLanguage($bot));
        //         $bot->reply($bot->getUser()->getId());
        // $bot->reply($bot->getUser()->getUsername() ?? 'getUsername');
        // $bot->reply($bot->getUser()->getFirstName() ?? 'getFirstName');
        // $bot->reply($bot->getUser()->getLastName() ?? 'getLastName');

        $bot->reply('Driver: ' . $bot->getDriver()->getName());

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

        $bot->reply('Че по кнопочкам?)', $keyboard->toArray());
    }
}
