<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Language;

use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class SelectLanguageAction
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
    ) {
    }

    public function handle(): void
    {
        $message = 'Please select language';

        $this->bot->reply(
            message: $this->botHelper->translate($this->bot, $message),
            additionalParameters: $this->selectLanguagesKeyboard()
        );
    }

    private function selectLanguagesKeyboard(): array
    {
        $keyboard = Keyboard::create();

        $keyboard->addRow(
            KeyboardButton::create('󠁥󠁮🇬🇧 󠁿English')->callbackData(json_encode(['locale' => 'en'])),
            KeyboardButton::create('🇪🇸 Español')->callbackData(json_encode(['locale' => 'es']))
        );

        $keyboard->addRow(
            KeyboardButton::create('🇷🇺 Русский')->callbackData(json_encode(['locale' => 'ru'])),
            KeyboardButton::create('󠁥󠁮🇬🇧 󠁿Türkçe')->callbackData(json_encode(['locale' => 'tr'])),
        );

        return $keyboard->toArray();
    }
}
