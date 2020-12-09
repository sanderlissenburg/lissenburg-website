<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\ReadModel\Story;
use App\Application\ReadModel\Tag;
use App\Application\Repository\StoryRepository;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;

final class DbalStoryRepository implements StoryRepository
{

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $slug
     * @return Story
     * @throws \Doctrine\DBAL\Exception
     * @throws \Exception
     */
    public function getBySlug(string $slug): Story
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from('stories')
            ->where('slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1);

        $story = $qb->execute()->fetchAssociative();

        if (!$story) {
            throw new \Exception('Story not found', 404);
        }

        return new Story(
            (int) $story['id'],
            $story['type'],
            $story['title'],
            $story['slug'],
            $story['intro'],
            $story['content'],
            new DateTime($story['created_at']),
            (bool) $story['active'],
            []
        );
    }

    /**
     * @param int $from
     * @param int $size
     * @param array|null $types
     * @param bool $active
     * @return iterable
     * @throws \Doctrine\DBAL\Exception
     */
    public function getPaginated(int $from = 1, int $size = 10, ?array $types = null, bool $active = true): iterable
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('*')
            ->from('stories')
            ->where('active = :active')
            ->setParameter('active', $active)
            ->setFirstResult($from - 1)
            ->setMaxResults($size)
            ->orderBy('created_at', 'DESC')
        ;

        if ($types !== null) {
            $qb
                ->andWhere("type IN(:types)")
                ->setParameter('types', $types, Connection::PARAM_STR_ARRAY)
            ;
        }

        $result = $qb->execute();
        $stories =  $result->fetchAllAssociative();

        if (empty($stories)) {
            return;
        }

        $storyIds = array_map(function ($story) {
            return (int) $story['id'];
        }, $stories);

        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->select('st.story_id, t.*')
            ->from('story_tag', 'st')
            ->join('st', 'tags', 't', 't.id = st.tag_id')
            ->where('st.story_id IN(:story_ids)')
            ->setParameter('story_ids', $storyIds, Connection::PARAM_STR_ARRAY)
        ;

        $result = $qb->execute();
        $tags = $result->fetchAllAssociative();
        $tagsForStory = array_reduce($tags, function ($reducer, $tag) {
            $reducer[$tag['story_id']][] = new Tag(
                (int) $tag['id'],
                $tag['label']
            );

            return $reducer;
        }, []);

        foreach($stories as $story) {
            yield new Story(
                (int) $story['id'],
                $story['type'],
                $story['title'],
                $story['slug'],
                $story['intro'],
                $story['content'],
                new DateTime($story['created_at']),
                (bool) $story['active'],
                $tagsForStory[$story['id']] ?? []
            );
        }
    }
}
