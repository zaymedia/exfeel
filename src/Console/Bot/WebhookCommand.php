<?php

declare(strict_types=1);

namespace App\Console\Bot;

use App\Console\Bot\Callbacks\BalanceCallback;
use App\Console\Bot\Callbacks\FallbackCallback;
use App\Console\Bot\Callbacks\HelpCallback;
use App\Console\Bot\Callbacks\LanguageCallback;
use App\Console\Bot\Callbacks\StartCallback;
use App\Console\Bot\Callbacks\SubscribersCallback;
use App\Console\Bot\Conversations\LanguageConversation;
use BotMan\BotMan\BotMan;
use ZayMedia\Shared\Components\Cacher\RedisCacher;

final class WebhookCommand
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
    ) {
    }

    public function handle(): void
    {
        //        $this->bot->hears(
        //            StartCallback::getPattern(),
        //            function (BotMan $bot) {
        //                (new StartCallback($bot, $this->botHelper))->handle();
        //            }
        //        );

        //        $this->bot->types();
        //        $this->bot->reply($this->bot->getMessage()->getText());

        $redis = new RedisCacher(
            host: \App\Components\env('REDIS_HOST'),
            port: (int)\App\Components\env('REDIS_PORT'),
            password: \App\Components\env('REDIS_PASSWORD')
        );

        $redis->set('test', 'test');

        $this->bot->hears(
            '/start', // StartCallback::getPattern(),
            function (BotMan $bot) {
                //                $bot->reply(\App\Components\env('REDIS_HOST') . ' ' . \App\Components\env('REDIS_PASSWORD'));
                $bot->startConversation(new LanguageConversation());
            }
        );

        //        $this->bot->hears(
        //            SubscribersCallback::getPattern(),
        //            function (BotMan $bot) {
        //                (new SubscribersCallback($bot, $this->botHelper))->handle();
        //            }
        //        );
        //
        //        $this->bot->hears(
        //            BalanceCallback::getPattern(),
        //            function (BotMan $bot) {
        //                (new BalanceCallback($bot, $this->botHelper))->handle();
        //            }
        //        );
        //
        //        $this->bot->hears(
        //            LanguageCallback::getPattern(),
        //            function (BotMan $bot) {
        //                (new LanguageCallback($bot, $this->botHelper))->handle();
        //            }
        //        );
        //
        //        $this->bot->hears(
        //            HelpCallback::getPattern(),
        //            function (BotMan $bot) {
        //                (new HelpCallback($bot, $this->botHelper))->handle();
        //            }
        //        );

        //        $this->bot->fallback(
        //            function (BotMan $bot) {
        //                (new FallbackCallback($bot, $this->botHelper))->handle();
        //            }
        //        );

        $this->bot->listen();
    }
}
