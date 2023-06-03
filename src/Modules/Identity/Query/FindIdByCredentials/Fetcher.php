<?php

declare(strict_types=1);

namespace App\Modules\Identity\Query\FindIdByCredentials;

use App\Modules\Identity\Service\PasswordHasher;
use Doctrine\DBAL\Connection;

final class Fetcher
{
    public function __construct(
        private readonly Connection $connection,
        private readonly PasswordHasher $passwordHasher,
    ) {
    }

    public function fetch(Query $query): ?User
    {
        $username = mb_strtolower($query->username);
        $username = trim($username, '+');

        if (is_numeric($username) && \strlen($username) === 11 && str_starts_with($username, '8')) {
            $username = '7' . substr($username, 1);
        }

        $result = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'password',
            ])
            ->from('users')
            ->where('(email = :username || phone = :username) && deleted IS NULL && blocked IS NULL')
            ->setParameter('username', $username)
            ->executeQuery();

        /** @var array{id: int, password: ?string}|false */
        $row = $result->fetchAssociative();

        if ($row === false) {
            return null;
        }

        $hash = $row['password'];

        if ($hash === null) {
            return null;
        }

        if (!$this->passwordHasher->validate($query->password, $hash)) {
            return null;
        }

        return new User(
            id: $row['id'],
            isActive: true// $row['status'] === Status::ACTIVE
        );
    }
}
