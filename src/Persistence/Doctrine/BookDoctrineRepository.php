<?php

declare(strict_types=1);

namespace App\Persistence\Doctrine;

use App\Model\Book;
use App\Persistence\Repository\BookRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends DoctrineRepository<Book>
 * @implements BookRepositoryInterface<Book>
 */
final class BookDoctrineRepository extends DoctrineRepository implements BookRepositoryInterface
{
    final public const string ENTITY_CLASS = Book::class;
    final public const string ALIAS = 'book';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, self::ENTITY_CLASS, self::ALIAS);
    }

    public function ofId(string $id): ?Book
    {
        return $this->find($id);
    }

    public function withTitle(string $title): BookRepositoryInterface
    {
        return $this->filter(function (QueryBuilder $queryBuilder) use ($title): void {
            $queryBuilder
                ->andWhere(sprintf('%s.title = :title', self::ALIAS))
                ->setParameter('title', $title)
            ;
        });
    }

    public function withAuthor(string $author): BookRepositoryInterface
    {
        return $this->filter(function (QueryBuilder $queryBuilder) use ($author): void {
            $queryBuilder
                ->andWhere(sprintf('%s.author = :author', self::ALIAS))
                ->setParameter('author', $author)
            ;
        });
    }

    public function save(Book $book): void
    {
        $this->getEntityManager()->persist($book);
        $this->getEntityManager()->flush();
    }

    public function delete(Book $book): void
    {
        $this->getEntityManager()->remove($book);
        $this->getEntityManager()->flush();
    }
}
