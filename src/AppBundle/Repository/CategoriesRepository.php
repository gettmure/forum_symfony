<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Categories;
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

    public function findAllSubcategories(Categories $category)
    {
        $sql = 'SELECT * FROM categories WHERE parent_id = ?';
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $stmt = $connection->prepare($sql);
        $stmt->execute([$category->getId()]);

        return $stmt->fetchAll();
    }
}