<?php

declare(strict_types=1);

namespace App\Persistence\InMemory;

use App\Model\Book;
use App\Persistence\Repository\BookRepositoryInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When(env: 'test')]
#[AsAlias(BookRepositoryInterface::class)]
final class BookInMemoryRepository extends InMemoryRepository implements BookRepositoryInterface
{
    public function ofId(string $id): ?Book
    {
        return $this->entities[$id] ?? null;
    }

    public function withTitle(string $title): BookRepositoryInterface
    {
        return $this->filter(fn (Book $book) => $book->title() === $title);
    }

    public function withAuthor(string $author): BookRepositoryInterface
    {
        return $this->filter(fn (Book $book) => $book->author() === $author);
    }

    public function save(Book $book): void
    {
        $this->entities[$book->id()] = $book;
    }

    public function delete(Book $book): void
    {
        unset($this->entities[$book->id()]);
    }
}
