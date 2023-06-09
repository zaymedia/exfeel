<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Fallback;

use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;

class FallbackCallback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly SearchUserAction $searchUserAction,
    ) {
    }

    public function __invoke(): void
    {
        $this->bot->typesAndWaits($this->botHelper->getTypingSeconds());

        $message = $this->bot->getMessage()->getText();

        if (!str_contains($message, ' ')) {
            $this->searchUserAction->handle();
            return;
        }

        $message = '
            Команда не распознана.

            Если Вы хотите найти пользователя или контент, то используйте веб-ссылки Instagram или никнеймы пользователей без пробелов.

            Обратите внимание, что используются только символы латиницы (A-Z), цифры (0-9) и служебные символы (-, _, /, .).
        ';

        //        $message = 'Sorry, I did not understand these commands.' . PHP_EOL .
        //            $this->bot->getMessage()->getText() . PHP_EOL .
        //            json_encode($this->bot->getMessage()->getPayload());

        $this->bot->reply($message);
    }
}
