<?php


namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoriesRepository extends EntityRepository
{
    public function findOneByCategoryName($categoryName)
    {
        $sql = 'SELECT * FROM categories WHERE categories.category_name = ?';
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $stmt = $connection->prepare($sql);
        $stmt->execute([$categoryName]);

        return $stmt->fetchColumn();
    }
}