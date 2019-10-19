<?php

namespace Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use UsersSearch\User;
use UsersSearch\UserCollection;
use UsersSearch\UserRepository;

class DoctrineUserRepository implements UserRepository
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * DoctrineLandingPageRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $terms
     * @param bool $filterDuplicates
     * @return UserCollection
     */
    public function findByTerms(string $terms, bool $filterDuplicates = false): UserCollection
    {
        $distinct = $filterDuplicates ? 'DISTINCT (user.lastName), ' : '';
        $userCollection = new UserCollection();

        $query = $this->entityManager->createQueryBuilder()
            ->select($distinct . 'user.firstName, user.lastName')
            ->from(User::class, 'user')
            ->where('user.firstName LIKE :terms')
            ->orWhere('user.lastName LIKE :terms')
            ->setParameter('terms', addcslashes($terms, '%_').'%')
            ->addOrderBy('user.lastName', 'ASC')
            ->addOrderBy('user.firstName', 'ASC');

        $results = $query
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $userCollection->add(User::named($result['firstName'], $result['lastName']));
        }

        return $userCollection;
    }
}
