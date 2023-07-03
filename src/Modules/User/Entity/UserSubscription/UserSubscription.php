<?php

declare(strict_types=1);

namespace App\Modules\User\Entity\UserSubscription;

use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: UserSubscription::DB_NAME)]
#[ORM\Index(fields: ['userId'], name: 'IDX_USER_ID')]
#[ORM\Index(fields: ['instagramProfileId'], name: 'IDX_INSTAGRAM_PROFILE_ID')]
final class UserSubscription
{
    public const DB_NAME = 'user_subscription';

    #[ORM\Id]
    #[ORM\Column(type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'bigint')]
    private int $userId;

    #[ORM\Column(type: 'bigint')]
    private int $instagramProfileId;

    #[ORM\Column(type: 'boolean')]
    private bool $isNotification;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $storiesExpirationAt = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $storiesArchiveExpirationAt = null;

    #[ORM\Column(type: 'integer')]
    private int $subscribedAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $unsubscribedAt = null;

    public function __construct(
        int $userId,
        int $instagramProfileId,
    ) {
        $this->userId = $userId;
        $this->instagramProfileId = $instagramProfileId;
        $this->isNotification = true;
        $this->subscribedAt = time();
    }

    public static function create(
        int $userId,
        int $profileId,
    ): self {
        return new self(
            userId: $userId,
            instagramProfileId: $profileId,
        );
    }

    public function reSubscribe(): void
    {
        $this->isNotification = true;
        $this->unsubscribedAt = null;
    }

    public function unsubscribe(): void
    {
        $this->unsubscribedAt = time();
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getInstagramProfileId(): int
    {
        return $this->instagramProfileId;
    }

    public function setInstagramProfileId(int $instagramProfileId): void
    {
        $this->instagramProfileId = $instagramProfileId;
    }

    public function isNotification(): bool
    {
        return $this->isNotification;
    }

    public function setIsNotification(bool $isNotification): void
    {
        $this->isNotification = $isNotification;
    }

    public function getStoriesExpirationAt(): ?int
    {
        return $this->storiesExpirationAt;
    }

    public function setStoriesExpirationAt(?int $storiesExpirationAt): void
    {
        $this->storiesExpirationAt = $storiesExpirationAt;
    }

    public function getStoriesArchiveExpirationAt(): ?int
    {
        return $this->storiesArchiveExpirationAt;
    }

    public function setStoriesArchiveExpirationAt(?int $storiesArchiveExpirationAt): void
    {
        $this->storiesArchiveExpirationAt = $storiesArchiveExpirationAt;
    }

    public function getSubscribedAt(): int
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(int $subscribedAt): void
    {
        $this->subscribedAt = $subscribedAt;
    }

    public function getUnsubscribedAt(): ?int
    {
        return $this->unsubscribedAt;
    }

    public function setUnsubscribedAt(?int $unsubscribedAt): void
    {
        $this->unsubscribedAt = $unsubscribedAt;
    }
}
