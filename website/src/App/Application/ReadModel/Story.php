<?php
declare(strict_types=1);

namespace App\Application\ReadModel;

use DateTimeInterface;

final class Story
{
    const TYPE_LONG = 'long';
    const TYPE_SHORT = 'short';

    private int $id;

    private string $type;

    private string $title;

    private string $slug;

    private string $intro;

    private string $content;

    private DateTimeInterface $createdAt;

    private bool $active;

    /**
     * @var Tag[]
     */
    private array $tags;

    /**
     * @param int $id
     * @param string $type
     * @param string $title
     * @param string $slug
     * @param string $intro
     * @param string $content
     * @param DateTimeInterface $createdAt
     * @param bool $active
     * @param Tag[] $tags
     */
    public function __construct(
        int $id,
        string $type,
        string $title,
        string $slug,
        string $intro,
        string $content,
        DateTimeInterface $createdAt,
        bool $active,
        array $tags
    )
    {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->slug = $slug;
        $this->intro = $intro;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->active = $active;
        $this->tags = $tags;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getIntro(): string
    {
        return $this->intro;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
