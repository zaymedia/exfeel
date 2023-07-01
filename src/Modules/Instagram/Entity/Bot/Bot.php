<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Entity\Bot;

use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: Bot::DB_NAME)]
#[ORM\Index(fields: ['proxyId'], name: 'IDX_PROXY_ID')]
final class Bot
{
    public const DB_NAME = 'instagram_bot';

    #[ORM\Id]
    #[ORM\Column(type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $proxyId;

    #[ORM\Column(type: 'integer')]
    private int $status;

    #[ORM\Column(type: 'boolean')]
    private bool $isFailLogin = false;

    #[ORM\Column(type: 'integer')]
    private int $countTasksToday = 0;

    #[ORM\Column(type: 'integer')]
    private int $countTasksAll = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $timeStories = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $timePost = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $emailPass = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $activatedAt = null;

    #[ORM\Column(type: 'integer')]
    private int $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $updatedAt = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $deletedAt = null;

    public function __construct(
        string $username,
        string $password,
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->proxyId = null;
        $this->status = 0;
        $this->createdAt = time();
    }

    public static function createByPhone(
        string $username,
        string $password,
        string $phone,
    ): self {
        $bot = new self(
            username: $username,
            password: $password,
        );

        $bot->setPhone($phone);

        return $bot;
    }

    public static function createByEmail(
        string $username,
        string $password,
        string $email,
        string $emailPassword,
    ): self {
        $bot = new self(
            username: $username,
            password: $password,
        );

        $bot->setEmail($email);
        $bot->setEmailPass($emailPassword);

        return $bot;
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getProxyId(): ?int
    {
        return $this->proxyId;
    }

    public function setProxyId(?int $proxyId): void
    {
        $this->proxyId = $proxyId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function isFailLogin(): bool
    {
        return $this->isFailLogin;
    }

    public function setIsFailLogin(bool $isFailLogin): void
    {
        $this->isFailLogin = $isFailLogin;
    }

    public function getCountTasksToday(): int
    {
        return $this->countTasksToday;
    }

    public function setCountTasksToday(int $countTasksToday): void
    {
        $this->countTasksToday = $countTasksToday;
    }

    public function getCountTasksAll(): int
    {
        return $this->countTasksAll;
    }

    public function setCountTasksAll(int $countTasksAll): void
    {
        $this->countTasksAll = $countTasksAll;
    }

    public function getTimeStories(): ?int
    {
        return $this->timeStories;
    }

    public function setTimeStories(?int $timeStories): void
    {
        $this->timeStories = $timeStories;
    }

    public function getTimePost(): ?int
    {
        return $this->timePost;
    }

    public function setTimePost(?int $timePost): void
    {
        $this->timePost = $timePost;
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

    public function getEmailPass(): ?string
    {
        return $this->emailPass;
    }

    public function setEmailPass(?string $emailPass): void
    {
        $this->emailPass = $emailPass;
    }

    public function getActivatedAt(): ?int
    {
        return $this->activatedAt;
    }

    public function setActivatedAt(?int $activatedAt): void
    {
        $this->activatedAt = $activatedAt;
    }

    public function getcreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setcreatedAt(int $createdAt): void
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
