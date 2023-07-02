<?php

declare(strict_types=1);

namespace App\Modules\User\Command\UpdateLanguage;

use App\Modules\User\Entity\User\UserRepository;
use ZayMedia\Shared\Components\Flusher;

final class UpdateLanguageHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Flusher $flusher
    ) {
    }

    public function handle(UpdateLanguageCommand $command): void
    {
        $user = $this->userRepository->getById($command->userId);

        $user->setLanguage($command->language);

        $this->flusher->flush();
    }
}
