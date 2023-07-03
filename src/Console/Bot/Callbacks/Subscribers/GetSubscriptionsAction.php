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
            '/subscriptions:([0-9]+)',
        ];
    }

    public function handle(): void
    {
        $text = $this->bot->getMessage()->getText();
        $offset = (int)(explode(':', $text)[1] ?? 0);

        /** @var array{id: int, user_id: int, username: string}[] $subscriptions */
        $subscriptions = $this->getSubscriptionsFetcher->fetch(
            new GetSubscriptionsQuery(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                count: self::PAGE_COUNT + 1,
                offset: $offset
            )
        );

        if ($text !== '/subscriptions') {
            /** @var array{message_id: int, chat: array{id: int}} $payload */
            $payload = $this->bot->getMessage()->getPayload();

            $this->bot->sendRequest(
                'editMessage',
                array_merge(
                    [
                        'chat_id' => $payload['chat']['id'],
                        'message_id' => $payload['message_id'],
                        'text' => 'upd m',
                    ],
                    $this->keyboard($subscriptions, 0)
                )
            );

            return;
        }

        $message = 'Выберите аккаунт:';

        $this->bot->reply(
            message: $this->botHelper->translate($message),
            additionalParameters: $this->keyboard($subscriptions, $offset)
        );
    }

    private function keyboard(array $subscriptions, int $offset): array
    {
        $keyboard = Keyboard::create();

        $chunks = array_chunk(
            array: \array_slice($subscriptions, 0, self::PAGE_COUNT),
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

        $buttons = [];

        if ($offset > 0) {
            $prev = $offset - self::PAGE_COUNT;
            $buttons[] = KeyboardButton::create('«')->callbackData('/subscriptions:' . $prev);
        }

        if (\count($subscriptions) > self::PAGE_COUNT) {
            $next = $offset + self::PAGE_COUNT;
            $buttons[] = KeyboardButton::create('»')->callbackData('/subscriptions:' . $next);
        }

        if (!empty($buttons)) {
            $keyboard->addRow(...$buttons);
        }

        return $keyboard->toArray();
    }
}
