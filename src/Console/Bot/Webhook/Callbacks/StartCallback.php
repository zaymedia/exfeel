<?php

declare(strict_types=1);

namespace App\Console\Bot\Webhook\Callbacks;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class StartCallback
{
    public function handle(BotMan $bot): void
    {
        /** @var array{
         *      user: array{
         *          language_code: string|null
         *      }|null
         * }|null $info
         */
        $info = $bot->getUser()->getInfo();

        $languageCode = $info['user']['language_code'] ?? null;

        // $bot->reply(json_encode($info));
        $bot->reply('Language: ' . ($languageCode ?? '-'));
        // $bot->reply($bot->getUser()->getId());
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
