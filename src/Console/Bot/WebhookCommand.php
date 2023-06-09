<?php

declare(strict_types=1);

namespace App\Console\Bot;

use App\Console\Bot\Callbacks\BalanceCallback;
use App\Console\Bot\Callbacks\Fallback\FallbackCallback;
use App\Console\Bot\Callbacks\HelpCallback;
use App\Console\Bot\Callbacks\Language\LanguageCallback;
use App\Console\Bot\Callbacks\StartCallback;
use App\Console\Bot\Callbacks\Subscribers\SubscriptionsCallback;
use BotMan\BotMan\BotMan;

final class WebhookCommand
{
    public function __construct(
        private readonly BotMan $bot,
    ) {
    }

    public function handle(): void
    {
        $this->bot->hears(StartCallback::getPattern(), StartCallback::class);
        $this->bot->hears(SubscriptionsCallback::getPattern(), SubscriptionsCallback::class);
        $this->bot->hears(BalanceCallback::getPattern(), BalanceCallback::class);
        $this->bot->hears(LanguageCallback::getPattern(), LanguageCallback::class);
        $this->bot->hears(HelpCallback::getPattern(), HelpCallback::class);

        $this->bot->fallback(FallbackCallback::class);

        $this->bot->listen();
    }
}
