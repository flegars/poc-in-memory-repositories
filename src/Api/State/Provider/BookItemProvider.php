<?php

declare(strict_types=1);

namespace App\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\Resources\BookResource;
use App\Persistence\Repository\BookRepositoryInterface;

/**
 * @implements ProviderInterface<BookResource>
 */
final readonly class BookItemProvider implements ProviderInterface
{
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $book = $this->bookRepository->ofId($uriVariables['id']);

        return BookResource::fromModel($book);
    }
}
