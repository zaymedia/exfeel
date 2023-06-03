<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Entity\Profile;

use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: 'instagram_profile')]
final class Profile
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'bigint')]
    private int $userId;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(type: 'boolean')]
    private bool $isFree;

    #[ORM\Column(type: 'boolean')]
    private bool $isPrivate;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified;

    #[ORM\Column(type: 'boolean')]
    private bool $isBusiness;

    #[ORM\Column(type: 'integer')]
    private int $mediaCount;

    #[ORM\Column(type: 'integer')]
    private int $followerCount;

    #[ORM\Column(type: 'integer')]
    private int $followingCount;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $biography;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photos;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photo;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photoHost;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photoFileId;

    #[ORM\Column(type: 'integer')]
    private int $storiesTimeStart;

    #[ORM\Column(type: 'integer')]
    private int $storiesTime;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $lastStoryId;

    #[ORM\Column(type: 'integer')]
    private int $lastStoryAt;

    #[ORM\Column(type: 'integer')]
    private int $countStories;

    #[ORM\Column(type: 'integer')]
    private int $countPosts;

    #[ORM\Column(type: 'integer')]
    private int $countComments;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $notFoundAt;

    #[ORM\Column(type: 'integer')]
    private int $createAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $updatedAt = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $deletedAt = null;

    public function __construct(
        int $userId,
        string $username,
        bool $isFree,
        bool $isPrivate,
        bool $isVerified,
        bool $isBusiness,
        int $mediaCount,
        int $followerCount,
        int $followingCount,
        ?string $biography,
        ?string $photo,
        ?string $photoHost,
        ?string $photoFileId,
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->isFree = $isFree;
        $this->isPrivate = $isPrivate;
        $this->isVerified = $isVerified;
        $this->isBusiness = $isBusiness;
        $this->mediaCount = $mediaCount;
        $this->followerCount = $followerCount;
        $this->followingCount = $followingCount;
        $this->biography = $biography;
        $this->photos = null;
        $this->photo = $photo;
        $this->photoHost = $photoHost;
        $this->photoFileId = $photoFileId;

        $this->storiesTimeStart = 0;
        $this->storiesTime = 0;
        $this->lastStoryId = null;
        $this->lastStoryAt = 0;

        $this->countStories = 0;
        $this->countPosts = 0;
        $this->countComments = 0;

        $this->notFoundAt = null;

        $this->createAt = time();
    }

    public static function create(
        int $userId,
        string $username,
        bool $isFree,
        bool $isPrivate,
        bool $isVerified,
        bool $isBusiness,
        int $mediaCount,
        int $followerCount,
        int $followingCount,
        ?string $biography,
        ?string $photo,
        ?string $photoHost,
        ?string $photoFileId,
    ): self {
        return new self(
            userId: $userId,
            username: $username,
            isFree: $isFree,
            isPrivate: $isPrivate,
            isVerified: $isVerified,
            isBusiness: $isBusiness,
            mediaCount: $mediaCount,
            followerCount: $followerCount,
            followingCount: $followingCount,
            biography: $biography,
            photo: $photo,
            photoHost: $photoHost,
            photoFileId: $photoFileId,
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function isFree(): bool
    {
        return $this->isFree;
    }

    public function setIsFree(bool $isFree): void
    {
        $this->isFree = $isFree;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(bool $isPrivate): void
    {
        $this->isPrivate = $isPrivate;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }

    public function isBusiness(): bool
    {
        return $this->isBusiness;
    }

    public function setIsBusiness(bool $isBusiness): void
    {
        $this->isBusiness = $isBusiness;
    }

    public function getMediaCount(): int
    {
        return $this->mediaCount;
    }

    public function setMediaCount(int $mediaCount): void
    {
        $this->mediaCount = $mediaCount;
    }

    public function getFollowerCount(): int
    {
        return $this->followerCount;
    }

    public function setFollowerCount(int $followerCount): void
    {
        $this->followerCount = $followerCount;
    }

    public function getFollowingCount(): int
    {
        return $this->followingCount;
    }

    public function setFollowingCount(int $followingCount): void
    {
        $this->followingCount = $followingCount;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): void
    {
        $this->biography = $biography;
    }

    public function getPhotos(): ?string
    {
        return $this->photos;
    }

    public function setPhotos(?string $photos): void
    {
        $this->photos = $photos;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    public function getPhotoHost(): ?string
    {
        return $this->photoHost;
    }

    public function setPhotoHost(?string $photoHost): void
    {
        $this->photoHost = $photoHost;
    }

    public function getPhotoFileId(): ?string
    {
        return $this->photoFileId;
    }

    public function setPhotoFileId(?string $photoFileId): void
    {
        $this->photoFileId = $photoFileId;
    }

    public function getStoriesTimeStart(): int
    {
        return $this->storiesTimeStart;
    }

    public function setStoriesTimeStart(int $storiesTimeStart): void
    {
        $this->storiesTimeStart = $storiesTimeStart;
    }

    public function getStoriesTime(): int
    {
        return $this->storiesTime;
    }

    public function setStoriesTime(int $storiesTime): void
    {
        $this->storiesTime = $storiesTime;
    }

    public function getLastStoryId(): ?int
    {
        return $this->lastStoryId;
    }

    public function setLastStoryId(?int $lastStoryId): void
    {
        $this->lastStoryId = $lastStoryId;
    }

    public function getLastStoryAt(): int
    {
        return $this->lastStoryAt;
    }

    public function setLastStoryAt(int $lastStoryAt): void
    {
        $this->lastStoryAt = $lastStoryAt;
    }

    public function getCountStories(): int
    {
        return $this->countStories;
    }

    public function setCountStories(int $countStories): void
    {
        $this->countStories = $countStories;
    }

    public function getCountPosts(): int
    {
        return $this->countPosts;
    }

    public function setCountPosts(int $countPosts): void
    {
        $this->countPosts = $countPosts;
    }

    public function getCountComments(): int
    {
        return $this->countComments;
    }

    public function setCountComments(int $countComments): void
    {
        $this->countComments = $countComments;
    }

    public function getNotFoundAt(): ?int
    {
        return $this->notFoundAt;
    }

    public function setNotFoundAt(?int $notFoundAt): void
    {
        $this->notFoundAt = $notFoundAt;
    }

    public function getCreateAt(): int
    {
        return $this->createAt;
    }

    public function setCreateAt(int $createAt): void
    {
        $this->createAt = $createAt;
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
