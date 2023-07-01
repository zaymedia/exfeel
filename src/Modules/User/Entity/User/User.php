<?php

declare(strict_types=1);

namespace App\Modules\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: User::DB_NAME)]
#[ORM\Index(fields: ['driver', 'driverUserId'], name: 'IDX_DRIVER')]
final class User
{
    public const DB_NAME = 'user';

    #[ORM\Id]
    #[ORM\Column(type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $driver;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $driverUserId;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $username;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $firstName;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $lastName;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $language;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: 'integer')]
    private int $balance;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $refId = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $inviteCode = null;

    #[ORM\Column(type: 'integer')]
    private int $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $updatedAt = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $deletedAt = null;

    public function __construct(
        string $driver,
        string $driverUserId,
        ?string $username,
        ?string $firstName,
        ?string $lastName,
        ?string $language,
    ) {
        $this->driver = $driver;
        $this->driverUserId = $driverUserId;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->language = $language;
        $this->balance = 0;
        $this->createdAt = time();
    }

    public static function register(
        string $driver,
        string $driverUserId,
        ?string $username,
        ?string $firstName,
        ?string $lastName,
        ?string $language,
    ): self {
        return new self(
            driver: $driver,
            driverUserId: $driverUserId,
            username: $username,
            firstName: $firstName,
            lastName: $lastName,
            language: $language,
        );
    }

    public function getId(): int
    {
        if (null === $this->id) {
            throw new DomainException('Id not set');
        }
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDriver(): ?string
    {
        return $this->driver;
    }

    public function setDriver(?string $driver): void
    {
        $this->driver = $driver;
    }

    public function getDriverUserId(): ?string
    {
        return $this->driverUserId;
    }

    public function setDriverUserId(?string $driverUserId): void
    {
        $this->driverUserId = $driverUserId;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    public function getRefId(): ?int
    {
        return $this->refId;
    }

    public function setRefId(?int $refId): void
    {
        $this->refId = $refId;
    }

    public function getInviteCode(): ?string
    {
        return $this->inviteCode;
    }

    public function setInviteCode(?string $inviteCode): void
    {
        $this->inviteCode = $inviteCode;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?int $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?int
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?int $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
