<?php

declare(strict_types=1);

namespace App\Console\Bot\Webhook;

use App\Console\Bot\Webhook\Callbacks\BalanceCallback;
use App\Console\Bot\Webhook\Callbacks\FallbackCallback;
use App\Console\Bot\Webhook\Callbacks\HelpCallback;
use App\Console\Bot\Webhook\Callbacks\PhotoCallback;
use App\Console\Bot\Webhook\Callbacks\StartCallback;
use BotMan\BotMan\BotMan;

final class WebhookHandler
{
    public function __construct(
        private readonly BotMan $bot
    ) {
    }

    public function handle(): void
    {
        $this->bot->hears(StartCallback::getPattern(), StartCallback::getMethod());
        $this->bot->hears(HelpCallback::getPattern(), HelpCallback::getMethod());
        $this->bot->hears(BalanceCallback::getPattern(), BalanceCallback::getMethod());

        $this->bot->hears(PhotoCallback::getPattern(), PhotoCallback::getMethod());

        $this->bot->fallback(FallbackCallback::getMethod());

        $this->bot->listen();
    }
}
