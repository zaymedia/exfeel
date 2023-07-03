<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Subscribers;

use App\Console\Bot\BotHelper;
use App\Modules\User\Command\Unsubscribe\UnsubscribeCommand;
use App\Modules\User\Command\Unsubscribe\UnsubscribeHandler;
use BotMan\BotMan\BotMan;

class UnsubscribeAction
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly UnsubscribeHandler $unsubscribeHandler
    ) {
    }

    public static function commands(): array
    {
        return ['/unsubscribe:([0-9]+)'];
    }

    public function handle(): void
    {
        $text = $this->bot->getMessage()->getText();
        $userId = explode(':', $text)[1] ?? null;

        if (null === $userId) {
            return;
        }

        $this->unsubscribeHandler->handle(
            new UnsubscribeCommand(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                profileId: (int)$userId
            )
        );

        $message = 'Успешно отписались от пользователя **TODO**';

        $this->bot->reply(
            message: $this->botHelper->translate($message),
            additionalParameters: ['parse_mode' => 'Markdown']
        );
    }
}
