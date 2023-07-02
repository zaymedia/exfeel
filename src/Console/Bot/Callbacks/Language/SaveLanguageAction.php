<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Language;

use App\Console\Bot\BotHelper;
use App\Modules\User\Command\UpdateLanguage\UpdateLanguageCommand;
use App\Modules\User\Command\UpdateLanguage\UpdateLanguageHandler;
use BotMan\BotMan\BotMan;

class SaveLanguageAction
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly UpdateLanguageHandler $handler,
    ) {
    }

    public static function commands(): array
    {
        return ['/language'];
    }

    public function handle(): void
    {
        /** @var string|null $payload */
        $payload = $this->bot->getMessage()->getPayload();

        // $this->saveLanguage($payload ?? 'en');
        $this->saveLanguage('tr');

        $message = 'Language changed: ' . $this->bot->getMessage()->getText() . json_encode($payload);

        $this->bot->reply(
            message: $this->botHelper->translate($message),
        );
    }

    private function saveLanguage(string $language): void
    {
        $this->handler->handle(
            new UpdateLanguageCommand(
                userId: $this->botHelper->getOrRegisterUser()->getId(),
                language: $language
            )
        );
    }
}
