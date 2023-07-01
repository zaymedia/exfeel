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
                (new StartCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->hears(
            HelpCallback::getPattern(),
            function (BotMan $bot) {
                (new HelpCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->hears(
            BalanceCallback::getPattern(),
            function (BotMan $bot) {
                (new BalanceCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->hears(
            PhotoCallback::getPattern(),
            function (BotMan $bot) {
                (new PhotoCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->fallback(
            function (BotMan $bot) {
                (new FallbackCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->listen();
    }
}
