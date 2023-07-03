<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks;

use App\Console\Bot\BotHelper;
use App\Modules\Instagram\Query\Profile\Search\Fetcher;
use App\Modules\Instagram\Query\Profile\Search\Query;
use BotMan\BotMan\BotMan;

class FallbackCallback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly Fetcher $searchByUsernameFetcher,
    ) {
    }

    public function __invoke(): void
    {
        $this->bot->typesAndWaits($this->botHelper->getTypingSeconds());

        $profile = $this->searchByUsernameFetcher->fetch(
            new Query(
                username: $this->bot->getMessage()->getText()
            )
        );

        $this->bot->reply(json_encode($profile ?? []));

        $message = 'Sorry, I did not understand these commands.' . PHP_EOL .
            $this->bot->getMessage()->getText() . PHP_EOL .
            json_encode($this->bot->getMessage()->getPayload());

        $this->bot->reply($message);
    }
}
