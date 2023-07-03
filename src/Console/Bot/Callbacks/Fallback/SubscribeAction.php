<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Fallback;

use App\Console\Bot\BotHelper;
use App\Modules\User\Command\Subscribe\SubscribeCommand;
use App\Modules\User\Command\Subscribe\SubscribeHandler;
use BotMan\BotMan\BotMan;
use Doctrine\DBAL\Exception;

class SubscribeAction
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly SubscribeHandler $subscribeHandler
    ) {
    }

    public static function commands(): array
    {
        return ['/subscribe:([0-9]+)'];
    }

    /** @throws Exception */
    public function handle(): void
    {
        $text = $this->bot->getMessage()->getText();
        $userId = explode(':', $text)[1] ?? null;

        if (null === $userId) {
            return;
        }

        $this->subscribeHandler->handle(
            new SubscribeCommand(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                profileId: (int)$userId
            )
        );

        $message = 'Успешно подписались на пользователя **TODO** Вы можете отменить или настроить подписку в разделе «Подписки».';

        $this->bot->reply(
            message: $this->botHelper->translate($message),
        );
    }
}
