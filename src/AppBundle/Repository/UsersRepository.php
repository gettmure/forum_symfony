<?php


namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository
{
    public function findOneByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE users.name = ?';
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $stmt = $connection->prepare($sql);
        $stmt->execute([$username]);

        return $stmt->fetchColumn();
    }
}