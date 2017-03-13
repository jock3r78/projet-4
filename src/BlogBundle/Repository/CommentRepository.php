<?php

namespace BlogBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCommentReport($id)
    {
        return $this->createQueryBuilder('c')
            ->where('c.post = :id')
            ->setParameter('id', $id)
            ->andWhere('c.report > 0')
            ->orderBy('c.report', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getComments($id)
    {
        return $this->createQueryBuilder('c')
            ->where('c.post = :id')
            ->setParameter('id', $id)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getAllComments()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

}
