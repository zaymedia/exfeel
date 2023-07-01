<?php

declare(strict_types=1);

namespace App\Console\Bot;

use App\Console\Bot\Callbacks\BalanceCallback;
use App\Console\Bot\Callbacks\FallbackCallback;
use App\Console\Bot\Callbacks\HelpCallback;
use App\Console\Bot\Callbacks\PhotoCallback;
use App\Console\Bot\Callbacks\StartCallback;
use BotMan\BotMan\BotMan;

final class WebhookCommand
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
    ) {
    }

    public function handle(): void
    {
        $this->bot->hears(
            StartCallback::getPattern(),
            function (BotMan $bot) {
                $helpCallback = new StartCallback($this->botHelper);
                $helpCallback->handle($bot);
            }
        );

        $this->bot->hears(HelpCallback::getPattern(), HelpCallback::getMethod());
        $this->bot->hears(BalanceCallback::getPattern(), BalanceCallback::getMethod());

        $this->bot->hears(PhotoCallback::getPattern(), PhotoCallback::getMethod());

        $this->bot->fallback(FallbackCallback::class . '@handle');

        $this->bot->listen();
    }
}