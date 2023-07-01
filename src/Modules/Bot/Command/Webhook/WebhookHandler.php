<?php

declare(strict_types=1);

namespace App\Modules\Bot\Command\Webhook;

use BotMan\BotMan\BotMan;

final class WebhookHandler
{
    public function __construct(
        private readonly BotMan $botman
    ) {
    }

    public function handle(): void
    {
        // https://api.telegram.org/bot6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4/setwebhook?url=https://exfeel.zay.media/v1/webhooks/telegram
        // https://github.com/php-telegram-bot/example-bot/blob/master/hook.php

        $this->botman->hears('foo', 'App\Modules\Bot\Command\Webhook\Hears\InstagramPhoto@handleFoo');

        $this->botman->hears('hello', function (BotMan $bot) {
            $bot->reply('!!! Hello yourself :)))');
        });

        $this->botman->fallback(function (BotMan $bot) {
            $bot->reply('+++ Sorry, I did not understand these commands.');
        });

        $this->botman->hears('me', function (BotMan $bot) {
            $m = json_encode($this->botman->getUser()->getInfo());

            $bot->reply($m);
            $bot->reply($this->botman->getUser()->getId());
            $bot->reply($this->botman->getUser()->getUsername() ?? 'getUsername');
            $bot->reply($this->botman->getUser()->getFirstName() ?? 'getFirstName');
            $bot->reply($this->botman->getUser()->getLastName() ?? 'getLastName');

            $bot->reply('Driver:' . $this->botman->getDriver()->getName());
        });

        $this->botman->listen();
    }
}
