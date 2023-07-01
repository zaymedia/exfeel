<?php

declare(strict_types=1);

namespace App\Console\Bot\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class LanguageConversation extends Conversation
{
    protected string $firstname = '';

    protected string $email = '';

    public function askFirstname(): void
    {
        $this->ask('Hello! What is your firstname?', function (Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you ' . $this->firstname);
            $this->askEmail();
        });
    }

    public function askEmail(): void
    {
        $this->ask('One more thing - what is your email?', function (Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->say('Great - that is all we need, ' . $this->firstname);
        });
    }

    public function run(): void
    {
        // This will be called immediately
        $this->askFirstname();
    }
}
