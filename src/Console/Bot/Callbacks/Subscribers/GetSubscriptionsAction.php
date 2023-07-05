<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Subscribers;

use App\Console\Bot\BotHelper;
use App\Modules\User\Query\GetSubscriptions\GetSubscriptionsFetcher;
use App\Modules\User\Query\GetSubscriptions\GetSubscriptionsQuery;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
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
        $offset = 0; // (int)(explode(':', $text)[1] ?? 0);

        /** @var array{id: int, user_id: int, username: string}[] $subscriptions */
        $subscriptions = $this->getSubscriptionsFetcher->fetch(
            new GetSubscriptionsQuery(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                count: self::PAGE_COUNT + 1,
                offset: $offset
            )
        );

        // $this->bot->reply($text);

        if ($text !== '/subscriptions') {
            /** @var array{message_id: int, inline_message_id: int, chat: array{id: int}} $payload */
            $payload = $this->bot->getMessage()->getPayload();

            /** @var array{reply_markup: string} $keyboard */
            // $keyboard = $this->keyboard($subscriptions, 0);

            //            $keyboard = [
            //                [Button::create('Button 1')->value('button_1')],
            //                [Button::create('Button 2')->value('button_2')],
            //                [Button::create('Button 3')->value('button_3')],
            //            ];

            $p = [
                'chat_id' => $payload['chat']['id'],
                'message_id' => 1409, // $payload['message_id'],
                'text' => 'hu ' . $payload['message_id'],
                // 'reply_markup' => $keyboard['reply_markup'],
                //                'reply_markup' => json_encode([
                //                    'type' => 'inline_keyboard',
                //                    'keyboard' => $keyboard,
                //                    'one_time_keyboard' => false,
                //                ]),
                'reply_markup' => '{"inline_keyboard":[[{"text":"\u041a\u043d\u043e\u043f\u043a\u0430 ' . rand(6000, 7000) . '","callback_data":"button1"},{"text":"\u041a\u043d\u043e\u043f\u043a\u0430 222","callback_data":"button2"}],[{"text":"\u041a\u043d\u043e\u043f\u043a\u0430 3","callback_data":"button3"}]]}',
            ];

            $this->bot->sendRequest(
                'editMessageText',// editMessageText', // 'editMessageReplyMarkup'
                $p
            );

            //            $this->bot->reply(
            //                json_encode($p),
            //                [
            //                    'reply_markup' => json_encode([
            //                        'keyboard' => $keyboard,
            //                        'one_time_keyboard' => false,
            //                    ]),
            //                ]
            //            );

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
        $keyboard->oneTimeKeyboard(false);

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
