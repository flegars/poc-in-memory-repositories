<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Model\Book;

/**
 * @template T of object
 */
interface BookRepositoryInterface
{
    public function ofId(string $id): ?Book;

    public function withTitle(string $title): self;

    public function withAuthor(string $author): self;

    public function save(Book $book): void;

    public function delete(Book $book): void;
}
