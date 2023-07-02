<?php

declare(strict_types=1);

namespace App\Console\Bot;

use App\Console\Bot\Callbacks\BalanceCallback;
use App\Console\Bot\Callbacks\FallbackCallback;
use App\Console\Bot\Callbacks\HelpCallback;
use App\Console\Bot\Callbacks\Language;
use App\Console\Bot\Callbacks\StartCallback;
use App\Console\Bot\Callbacks\SubscribersCallback;
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
        $this->bot->hears(StartCallback::getPattern(), StartCallback::class);

        $this->bot->hears(
            SubscribersCallback::getPattern(),
            function (BotMan $bot) {
                (new SubscribersCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->hears(
            BalanceCallback::getPattern(),
            function (BotMan $bot) {
                (new BalanceCallback($bot, $this->botHelper))->handle();
            }
        );

        $this->bot->hears(
            Language\MainCallback::getPattern(),
            function (BotMan $bot) {
                (new Language\MainCallback($bot, $this->botHelper))->handle();
                // $bot->startConversation(new LanguageConversation());
            }
        );

        $this->bot->hears(
            HelpCallback::getPattern(),
            function (BotMan $bot) {
                (new HelpCallback($bot, $this->botHelper))->handle();
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
