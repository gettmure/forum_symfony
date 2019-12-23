<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Categories;
use Doctrine\ORM\EntityRepository;

class MessagesRepository extends EntityRepository
{
    public function findAllQueringRows()
    {
        $sql = 'SELECT DISTINCT ON (category_id) users.name, categories.category_name, text, posted_at FROM messages
                    INNER JOIN categories ON categories.id = messages.category_id
                    INNER JOIN users ON users.id = messages.author_id
                    WHERE category_id IN (
                    SELECT msg.category_id FROM (
                    SELECT DISTINCT ON (category_id, author_id) category_id FROM messages ORDER BY category_id, author_id, posted_at) AS msg GROUP BY (msg.category_id) HAVING COUNT(*) > 2 LIMIT 10)
                    ORDER BY category_id, posted_at DESC';

        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findAllCategoryMessages(Categories $category)
    {
        return $this->createQueryBuilder('messages')
            ->andWhere('messages.category = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->execute();
    }
}