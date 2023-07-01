<?php

declare(strict_types=1);

namespace App\Modules\User\Command\RegisterByDriver;

use App\Modules\User\Entity\User\User;
use App\Modules\User\Entity\User\UserRepository;
use ZayMedia\Shared\Components\Flusher;

final class RegisterByDriverHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Flusher $flusher
    ) {
    }

    public function handle(RegisterByDriverCommand $command): User
    {
        $user = User::register(
            driver: $command->driver,
            driverUserId: $command->userId,
            username: $command->username,
            firstName: $command->firstName,
            lastName: $command->lastName,
            language: $command->language,
        );

        $this->userRepository->add($user);

        $this->flusher->flush();

        return $user;
    }
}
