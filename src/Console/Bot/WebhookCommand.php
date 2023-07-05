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
use phpDocumentor\Reflection\Exception;
use ZayMedia\Shared\Components\Sentry;

final class WebhookCommand
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly Sentry $sentry,
    ) {
    }

    public function handle(): void
    {
        $this->sentry->capture(new Exception(json_encode($this->bot->getMessage()->getText())));

        $this->bot->hears(StartCallback::getPattern(), StartCallback::class);
        $this->bot->hears(SubscriptionsCallback::getPattern(), SubscriptionsCallback::class);
        $this->bot->hears(BalanceCallback::getPattern(), BalanceCallback::class);
        $this->bot->hears(LanguageCallback::getPattern(), LanguageCallback::class);
        $this->bot->hears(HelpCallback::getPattern(), HelpCallback::class);

        $this->bot->fallback(FallbackCallback::class);

        $this->bot->listen();
    }
}
