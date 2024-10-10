<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

/**
 * @template T of object
 *
 * @extends \IteratorAggregate<array-key, T>
 */
interface RepositoryInterface extends \IteratorAggregate
{
    /**
     * @return \Iterator<T>
     */
    public function getIterator(): \Iterator;

    public function count(array $criteria = []): int;
}
