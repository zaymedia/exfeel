<?php

declare(strict_types=1);

namespace App\Modules\Bot\Command\Webhook\HearsCallback;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class PhotoCallback
{
    public function handle(BotMan $bot): void
    {
        $attachment = new Image('https://img.freepik.com/free-photo/a-cupcake-with-a-strawberry-on-top-and-a-strawberry-on-the-top_1340-35087.jpg', [
            'custom_payload' => true,
        ]);

        $message = OutgoingMessage::create('This is my text')
            ->withAttachment($attachment);

        $bot->reply($message);
    }
}
