<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Fallback;

use App\Console\Bot\BotHelper;
use App\Modules\Instagram\Query\Profile\Search\SearchFetcher;
use App\Modules\Instagram\Query\Profile\Search\SearchQuery;
use App\Modules\User\Query\IsSubscribe\IsSubscribeFetcher;
use App\Modules\User\Query\IsSubscribe\IsSubscribeQuery;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use Doctrine\DBAL\Exception;

class SearchUserAction
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly SearchFetcher $searchUserFetcher,
        private readonly IsSubscribeFetcher $isSubscribeFetcher,
    ) {
    }

    /** @throws Exception */
    public function handle(): void
    {
        $username = $this->bot->getMessage()->getText();

        /** @var array{id: int, user_id: int, username: string}|null $profile */
        $profile = $this->searchUserFetcher->fetch(
            new SearchQuery(
                username: $username
            )
        );

        if (null !== $profile) {
            $profileId = $profile['id'];

            $isSubscribe = $this->isSubscribeFetcher->fetch(
                new IsSubscribeQuery(
                    userId: $this->botHelper->getOrRegisterUser()->getId(),
                    profileId: $profileId
                )
            );

            $message = 'Пользователь **' . $username . '** найден';

            if ($isSubscribe) {
                $keyboard = $this->keyboardUnsubscribe($profileId);
            } else {
                $keyboard = $this->keyboardSubscribe($profileId);
            }
        } else {
            $message = 'Пользователь **' . $username . '** не найден';
            $keyboard = [];
        }

        $this->bot->reply(
            message: $this->botHelper->translate($message),
            additionalParameters: $keyboard
        );
    }

    private function keyboardSubscribe(int $userId): array
    {
        $keyboard = Keyboard::create();

        $keyboard->addRow(
            KeyboardButton::create('Подписаться')->callbackData('/subscribe:' . $userId),
        );

        return $keyboard->toArray();
    }

    private function keyboardUnsubscribe(int $userId): array
    {
        $keyboard = Keyboard::create();

        $keyboard->addRow(
            KeyboardButton::create('Отписаться')->callbackData('/unsubscribe:' . $userId),
        );

        return $keyboard->toArray();
    }
}
