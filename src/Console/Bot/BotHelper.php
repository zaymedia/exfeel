<?php

declare(strict_types=1);

namespace App\Console\Bot;

use App\Modules\User\Command\RegisterByDriver\RegisterByDriverCommand;
use App\Modules\User\Command\RegisterByDriver\RegisterByDriverHandler;
use App\Modules\User\Entity\User\User;
use App\Modules\User\Entity\User\UserRepository;
use BotMan\BotMan\BotMan;
use Symfony\Component\Translation\Translator;

class BotHelper
{
    private bool $isNewUser = false;
    private int $typingSeconds = 1;

    public function __construct(
        private readonly BotMan $bot,
        private readonly UserRepository $userRepository,
        private readonly RegisterByDriverHandler $registerByDriverHandler,
        private readonly Translator $translator
    ) {
    }

    public function isNewUser(): bool
    {
        return $this->isNewUser;
    }

    public function getTypingSeconds(): int
    {
        return $this->typingSeconds;
    }

    public function getOrRegisterUser(): User
    {
        $driver = $this->bot->getDriver()->getName();
        $userId = $this->getUserId($this->bot);

        $user = $this->userRepository->findByDriverAndUserId($driver, $userId);

        if (null === $user) {
            $user = $this->registerByDriverHandler->handle(
                new RegisterByDriverCommand(
                    driver: $driver,
                    userId: $userId,
                    username: $this->bot->getUser()->getUsername(),
                    firstName: $this->bot->getUser()->getFirstName(),
                    lastName: $this->bot->getUser()->getLastName(),
                    language: $this->getLanguage(),
                )
            );

            $this->isNewUser = true;
        }

        return $user;
    }

    public function getLanguage(): string
    {
        /** @var array{
         *      user: array{
         *          language_code: string|null
         *      }|null
         * }|null $info
         */
        $info = $this->bot->getUser()->getInfo();

        return $info['user']['language_code'] ?? 'en';
    }

    public function translate(string $text): string
    {
        $user = $this->getOrRegisterUser();

        $this->translator->setLocale($user->getLanguage() ?? 'en');

        $l = $this->translator->getLocale();

        return $l . ':= ' . $this->translator->trans($text, [], 'bot');
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
