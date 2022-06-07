<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Blogpost;
use App\Entity\Commentaire;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commentaire $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Commentaire $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findCommentaires($value)
    {
        if($value instanceof Blogpost){
            $object='blogpost';
        }
        if($value instanceof Project){
            $object='project';
        }
        return $this->createQueryBuilder('c')
            ->andwhere('c.' . $object .'  =:val')
            ->andWhere('c.isPublished = true')
            ->setParameter('val', $value->getId())
            ->orderBy('c.id','DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     *  @return Commentaire[] Returns an array of Blogpost objects
     */
    public function lastTree()
        {
    return $this->createQueryBuilder('b')
        ->orderBy('b.id','DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult()
        ;
        }



}
