<?php

declare(strict_types=1);

namespace App\Modules\Instagram\Entity\Stories;

use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table(name: Stories::DB_NAME)]
#[ORM\Index(fields: ['userId'], name: 'IDX_USER_ID')]
#[ORM\UniqueConstraint(name: 'UNIQUE_STORY_ID', columns: ['story_id'])]
final class Stories
{
    public const DB_NAME = 'instagram_stories';

    #[ORM\Id]
    #[ORM\Column(type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: 'bigint')]
    private int $userId;

    #[ORM\Column(type: 'string', unique: true, nullable: true)]
    private ?string $storyId;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $photo;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photoHost;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photoFileId;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $photoBlur;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photoBlurHost;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photoBlurFileId;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $video;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $videoHost;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $videoFileId;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $url;

    #[ORM\Column(type: 'integer')]
    private int $takenAt;

    #[ORM\Column(type: 'integer')]
    private int $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $updatedAt = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $deletedAt = null;

    public function __construct(
        int $userId,
        string $storyId,
        ?string $photo,
        ?string $photoHost,
        ?string $photoFileId,
        ?string $photoBlur,
        ?string $photoBlurHost,
        ?string $photoBlurFileId,
        ?string $video,
        ?string $videoHost,
        ?string $videoFileId,
        ?string $url,
        int $takenAt
    ) {
        $this->userId = $userId;
        $this->storyId = $storyId;

        $this->photo = $photo;
        $this->photoHost = $photoHost;
        $this->photoFileId = $photoFileId;
        $this->photoBlur = $photoBlur;
        $this->photoBlurHost = $photoBlurHost;
        $this->photoBlurFileId = $photoBlurFileId;
        $this->video = $video;
        $this->videoHost = $videoHost;
        $this->videoFileId = $videoFileId;
        $this->url = $url;

        $this->takenAt = $takenAt;
        $this->createdAt = time();
    }

    public static function createPhoto(
        int $userId,
        string $storyId,
        ?string $photo,
        ?string $photoHost,
        ?string $photoFileId,
        int $takenAt
    ): self {
        return new self(
            userId: $userId,
            storyId: $storyId,
            photo: $photo,
            photoHost: $photoHost,
            photoFileId: $photoFileId,
            photoBlur: null,
            photoBlurHost: null,
            photoBlurFileId: null,
            video: null,
            videoHost: null,
            videoFileId: null,
            url: null,
            takenAt: $takenAt
        );
    }

    public static function createVideo(
        int $userId,
        string $storyId,
        ?string $video,
        ?string $videoHost,
        ?string $videoFileId,
        int $takenAt
    ): self {
        return new self(
            userId: $userId,
            storyId: $storyId,
            photo: null,
            photoHost: null,
            photoFileId: null,
            photoBlur: null,
            photoBlurHost: null,
            photoBlurFileId: null,
            video: $video,
            videoHost: $videoHost,
            videoFileId: $videoFileId,
            url: null,
            takenAt: $takenAt
        );
    }

    public function editPhotoBlur(
        ?string $photo,
        ?string $photoHost,
        ?string $photoFileId,
    ): void {
        $this->photoBlur = $photo;
        $this->photoBlurHost = $photoHost;
        $this->photoBlurFileId = $photoFileId;
        $this->updatedAt = time();
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

    public function getStoryId(): ?string
    {
        return $this->storyId;
    }

    public function setStoryId(string $storyId): void
    {
        $this->storyId = $storyId;
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

    public function getPhotoBlur(): ?string
    {
        return $this->photoBlur;
    }

    public function setPhotoBlur(?string $photoBlur): void
    {
        $this->photoBlur = $photoBlur;
    }

    public function getPhotoBlurHost(): ?string
    {
        return $this->photoBlurHost;
    }

    public function setPhotoBlurHost(?string $photoBlurHost): void
    {
        $this->photoBlurHost = $photoBlurHost;
    }

    public function getPhotoBlurFileId(): ?string
    {
        return $this->photoBlurFileId;
    }

    public function setPhotoBlurFileId(?string $photoBlurFileId): void
    {
        $this->photoBlurFileId = $photoBlurFileId;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    public function getVideoHost(): ?string
    {
        return $this->videoHost;
    }

    public function setVideoHost(?string $videoHost): void
    {
        $this->videoHost = $videoHost;
    }

    public function getVideoFileId(): ?string
    {
        return $this->videoFileId;
    }

    public function setVideoFileId(?string $videoFileId): void
    {
        $this->videoFileId = $videoFileId;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getTakenAt(): int
    {
        return $this->takenAt;
    }

    public function setTakenAt(int $takenAt): void
    {
        $this->takenAt = $takenAt;
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
