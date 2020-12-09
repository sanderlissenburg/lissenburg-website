<?php
declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\ReadModel\Story;

interface StoryRepository
{
    /**
     * @param string $slug
     * @return Story
     */
    public function getBySlug(string $slug): Story;

    /**
     * @param int $from
     * @param int $size
     * @param array|null $types
     * @param bool $active
     * @return Story[]
     */
    public function getPaginated(int $from = 1, int $size = 10, ?array $types = null, bool $active = true): iterable;
}
