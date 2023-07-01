<?php

declare(strict_types=1);

namespace App\Console\Bot;

use App\Modules\User\Command\RegisterByDriver\RegisterByDriverCommand;
use App\Modules\User\Command\RegisterByDriver\RegisterByDriverHandler;
use App\Modules\User\Entity\User\User;
use App\Modules\User\Entity\User\UserRepository;
use BotMan\BotMan\BotMan;

class BotHelper
{
    private bool $isNewUser = false;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RegisterByDriverHandler $registerByDriverHandler
    ) {
    }

    public function isNewUser(): bool
    {
        return $this->isNewUser;
    }

    public function getOrRegisterUser(BotMan $bot): User
    {
        $driver = $bot->getDriver()->getName();
        $userId = $this->getUserId($bot);

        $user = $this->userRepository->findByDriverAndUserId($driver, $userId);

        if (null === $user) {
            $user = $this->registerByDriverHandler->handle(
                new RegisterByDriverCommand(
                    driver: $driver,
                    userId: $userId,
                    username: $bot->getUser()->getUsername(),
                    firstName: $bot->getUser()->getFirstName(),
                    lastName: $bot->getUser()->getLastName(),
                    language: $this->getLanguage($bot),
                )
            );

            $this->isNewUser = true;
        }

        return $user;
    }

    public function getLanguage(BotMan $bot): string
    {
        /** @var array{
         *      user: array{
         *          language_code: string|null
         *      }|null
         * }|null $info
         */
        $info = $bot->getUser()->getInfo();

        return $info['user']['language_code'] ?? 'en';
    }

    private function getUserId(BotMan $bot): string
    {
        /**
         * @psalm-suppress RedundantCastGivenDocblockType
         * @noinspection PhpCastIsUnnecessaryInspection
         */
        return (string)$bot->getUser()->getId();
    }
}
