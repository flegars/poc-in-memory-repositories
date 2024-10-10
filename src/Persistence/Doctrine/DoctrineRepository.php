<?php

declare(strict_types=1);

namespace App\Persistence\Doctrine;

use App\Persistence\Repository\RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template T of object
 * @extends ServiceEntityRepository<T>
 * @implements RepositoryInterface<T>
 */
abstract class DoctrineRepository extends ServiceEntityRepository implements RepositoryInterface
{
    private QueryBuilder $queryBuilder;
    private EntityManagerInterface $entityManager;
    private string $entityClass;
    private string $alias;

    public function __construct(
        protected ManagerRegistry $registry,
        string $entityClass,
        string $alias,
    ) {
        parent::__construct($registry, $entityClass);

        $this->entityManager = $this->getEntityManager();
        $this->alias = $alias;
        $this->entityClass = $entityClass;
        $this->queryBuilder = $this->createQueryBuilder($alias);
    }

    protected function __clone()
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }

    public function getIterator(): \Iterator
    {
        yield from $this->queryBuilder->getQuery()->getResult();
    }

    public function count(array $criteria = []): int
    {
        if (null !== $paginator = $this->paginator()) {
            return count($paginator);
        }

        return (int) (clone $this->queryBuilder)
            ->select('count(1)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder);

        return $cloned;
    }
}
