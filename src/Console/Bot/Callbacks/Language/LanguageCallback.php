<?php

declare(strict_types=1);

namespace App\Console\Bot\Callbacks\Language;

use App\Components\Callback\Callback;

class LanguageCallback implements Callback
{
    public function __construct(
        private readonly SelectLanguageAction $selectLanguageAction,
    ) {
    }

    public function __invoke(): void
    {
        // $text = $this->bot->getMessage()->getText();
        $this->selectLanguageAction->handle();
    }

    public static function getPattern(): array
    {
        return ['/language'];
    }
}
