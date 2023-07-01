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
        $this->bot->hears('/start', StartCallback::class . '@handle');

        $this->bot->hears('/help', HelpCallback::class . '@handle');
        $this->bot->hears(['/balance', '/bal'], BalanceCallback::class . '@handle');

        $this->bot->hears('photo', PhotoCallback::class . '@handle');

        $this->bot->fallback(FallbackCallback::class . '@handle');

        $this->bot->listen();
    }
}
