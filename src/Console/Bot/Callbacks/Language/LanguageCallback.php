<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Language;

use App\Components\Callback\Callback;
use App\Console\Bot\BotHelper;
use BotMan\BotMan\BotMan;

class LanguageCallback implements Callback
{
    public function __construct(
        private readonly BotMan $bot,
        private readonly BotHelper $botHelper,
        private readonly SelectLanguageAction $selectLanguageAction,
        private readonly SaveLanguageAction $saveLanguageAction,
    ) {
    }

    public function __invoke(): void
    {
        $this->bot->typesAndWaits($this->botHelper->getTypingSeconds());

        $message = $this->bot->getMessage()->getText();

        if (\in_array($message, SelectLanguageAction::commands(), true)) {
            $this->selectLanguageAction->handle();
        } else {
            $this->saveLanguageAction->handle();
        }
    }

    public static function getPattern(): array
    {
        return array_merge(
            SelectLanguageAction::commands(),
            SaveLanguageAction::commands(),
        );
    }
}
