<?php

declare(strict_types=1);

namespace App\Persistence\InMemory;

use App\Persistence\Repository\RepositoryInterface;

/**
 * @template T of object
 * @implements RepositoryInterface<T>
 */
abstract class InMemoryRepository implements RepositoryInterface
{
    /** @var array<string, T> $entities */
    protected array $entities = [];

    public function getIterator(): \Iterator
    {
        yield from $this->entities;
    }

    public function count(array $criteria = []): int
    {
        return \count($this->entities);
    }

    /**
     * @param callable(mixed, mixed=): bool $filter
     *
     * @return static<T>
     */
    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $cloned->entities = \array_filter($cloned->entities, $filter);

        return $cloned;
    }
}
