<?php

declare(strict_types=1);

namespace App\Components\Callback;

use BotMan\BotMan\BotMan;

interface Callback
{
    public static function getMethod(): string;

    public static function getPattern(): array;

    public function handle(BotMan $bot): void;
}
