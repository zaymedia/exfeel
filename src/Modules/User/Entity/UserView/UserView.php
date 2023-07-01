<?php

declare(strict_types=1);

namespace App\Modules\User\Entity\UserView;

use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: UserView::DB_NAME)]
#[ORM\Index(fields: ['userId'], name: 'IDX_USER_ID')]
#[ORM\Index(fields: ['instagramProfileId'], name: 'IDX_INSTAGRAM_PROFILE_ID')]
#[ORM\Index(fields: ['instagramStoryId'], name: 'IDX_INSTAGRAM_STORY_ID')]
final class UserView
{
    public const DB_NAME = 'user_view';

    #[ORM\Id]
    #[ORM\Column(type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'bigint')]
    private int $userId;

    #[ORM\Column(type: 'bigint')]
    private int $instagramProfileId;

    #[ORM\Column(type: 'bigint')]
    private int $instagramStoryId;

    #[ORM\Column(type: 'integer')]
    private int $viewedStoryAt;

    #[ORM\Column(type: 'integer')]
    private int $viewedAt;

    public function __construct(
        int $userId,
        int $instagramProfileId,
        int $instagramStoryId,
        int $viewedStoryAt,
        int $viewedAt,
    ) {
        $this->userId = $userId;
        $this->instagramProfileId = $instagramProfileId;
        $this->instagramStoryId = $instagramStoryId;
        $this->viewedStoryAt = $viewedStoryAt;
        $this->viewedAt = $viewedAt;
    }

    public static function create(
        int $userId,
        int $instagramProfileId,
        int $instagramStoryId,
        int $viewedStoryAt,
        int $viewedAt,
    ): self {
        return new self(
            userId: $userId,
            instagramProfileId: $instagramProfileId,
            instagramStoryId: $instagramStoryId,
            viewedStoryAt: $viewedStoryAt,
            viewedAt: $viewedAt,
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

    public function getInstagramStoryId(): int
    {
        return $this->instagramStoryId;
    }

    public function setInstagramStoryId(int $instagramStoryId): void
    {
        $this->instagramStoryId = $instagramStoryId;
    }

    public function getViewedStoryAt(): int
    {
        return $this->viewedStoryAt;
    }

    public function setViewedStoryAt(int $viewedStoryAt): void
    {
        $this->viewedStoryAt = $viewedStoryAt;
    }

    public function getViewedAt(): int
    {
        return $this->viewedAt;
    }

    public function setViewedAt(int $viewedAt): void
    {
        $this->viewedAt = $viewedAt;
    }
}
