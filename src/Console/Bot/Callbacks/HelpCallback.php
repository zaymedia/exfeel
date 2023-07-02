<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class HelpCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper
    ) {
    }

    public function __invoke(): void
    {
        $this->bot->typesAndWaits($this->botHelper->getTypingSeconds());

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

        $attachment = new Image('https://img.freepik.com/free-photo/a-cupcake-with-a-strawberry-on-top-and-a-strawberry-on-the-top_1340-35087.jpg', [
            'custom_payload' => true,
        ]);

        $message = OutgoingMessage::create('Доступные команды:' . PHP_EOL . implode(PHP_EOL, $commands))
            ->withAttachment($attachment);

        $this->bot->reply($message, $keyboard->toArray());
    }

    public static function getPattern(): array
    {
        return ['/help'];
    }
}
