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
        return ['/language:([a-z]+)'];
    }

    public function handle(): void
    {
        $text = $this->bot->getMessage()->getText();
        $language = explode(':', $text)[1] ?? 'en';

        $this->saveLanguage($language);

        $message = 'Language changed: ' . $language;

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
