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
    private const PAGE_COUNT = 6;

    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly GetSubscriptionsFetcher $getSubscriptionsFetcher,
    ) {
    }

    public static function commands(): array
    {
        return [
            '/subscriptions',
            '/subscriptions:([0-9]+)'
        ];
    }

    public function handle(): void
    {
        /** @var array{id: int, user_id: int, username: string}[] $subscriptions */
        $subscriptions = $this->getSubscriptionsFetcher->fetch(
            new GetSubscriptionsQuery(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                count: self::PAGE_COUNT + 1
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

        $chunks = array_chunk(
            array: \array_slice($subscriptions, self::PAGE_COUNT),
            length: 2
        );

        foreach ($chunks as $chunk) {
            $buttons = [];

            /** @var array{id: int, username: string} $subscription */
            foreach ($chunk as $subscription) {
                $buttons[] = KeyboardButton::create('@' . $subscription['username'])->callbackData('/subscription:' . $subscription['id']);
            }

            $keyboard->addRow(...$buttons);
        }

        if (\count($subscriptions) > self::PAGE_COUNT) {
            $offset = self::PAGE_COUNT;

            $keyboard->addRow(
                KeyboardButton::create('»')->callbackData('/subscription:' . $offset)
            );
        }

        return $keyboard->toArray();
    }
}
