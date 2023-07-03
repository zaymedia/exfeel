<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Subscribers;

use App\Console\Bot\BotHelper;
use App\Modules\User\Query\GetSubscriptions\GetSubscriptionsFetcher;
use App\Modules\User\Query\GetSubscriptions\GetSubscriptionsQuery;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class GetSubscriptionsAction
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly GetSubscriptionsFetcher $getSubscriptionsFetcher,
    ) {
    }

    public static function commands(): array
    {
        return ['/subscriptions'];
    }

    public function handle(): void
    {
        /** @var array{id: int, user_id: int, username: string}[] $subscriptions */
        $subscriptions = $this->getSubscriptionsFetcher->fetch(
            new GetSubscriptionsQuery(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                count: 6
            )
        );

        $message = 'Выберите аккаунт:';

        $this->bot->reply(
            message: $this->botHelper->translate($message),
            additionalParameters: $this->keyboard($subscriptions)
        );
    }

    private function keyboard(array $subscriptions): array
    {
        $keyboard = Keyboard::create();

        /** @var array{id: int, username: string} $subscription */
        foreach ($subscriptions as $subscription) {
            $button = KeyboardButton::create('@' . $subscription['username'])->callbackData('/subscription:' . $subscription['id']);

            $keyboard->addRow($button);
        }

        return $keyboard->toArray();
    }
}
