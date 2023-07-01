<?php

declare(strict_types=1);

namespace App\Modules\Bot\Command\Webhook;

use App\Modules\Bot\Command\Webhook\HearsCallback\HelpCallback;
use App\Modules\Bot\Command\Webhook\HearsCallback\PhotoCallback;
use App\Modules\Bot\Command\Webhook\HearsCallback\StartCallback;
use BotMan\BotMan\BotMan;

final class WebhookHandler
{
    public function __construct(
        private readonly BotMan $bot
    ) {
    }

    public function handle(): void
    {
        // https://api.telegram.org/bot6194699354:AAGsIq2wAHBi44A2Vzj3zeEMpBvZ77oSMy4/setwebhook?url=https://exfeel.zay.media/v1/webhooks/telegram
        // https://github.com/php-telegram-bot/example-bot/blob/master/hook.php

        $this->bot->hears('/start', StartCallback::class);
        $this->bot->hears('/help', HelpCallback::class);
        $this->bot->hears('photo', PhotoCallback::class);

        $this->bot->hears('hello', function (BotMan $bot) {
            $bot->typesAndWaits(2);
            $bot->reply('Hello yourself :)');
        });

        $this->bot->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand these commands.');
            $bot->reply($bot->getMessage()->getText());
            $bot->reply(json_encode($bot->getMessage()->getPayload()));
        });

        $this->bot->listen();
    }
}
