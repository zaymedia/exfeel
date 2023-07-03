<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Subscribers;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;

class SubscribersCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly SubscribeAction $subscribeAction,
    ) {
    }

    public function __invoke(): void
    {
        $this->bot->typesAndWaits($this->botHelper->getTypingSeconds());

        $message = $this->bot->getMessage()->getText();

        if (str_contains($message, '/subscribe:')) {
            $this->subscribeAction->handle();
            return;
        }

        $this->bot->reply('subscribers');
    }

    public static function getPattern(): array
    {
        return array_merge(
            ['/subscribers'],
            SubscribeAction::commands(),
        );
    }
}
