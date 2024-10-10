<?php

declare(strict_types=1);

namespace App\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resources\BookResource;
use App\Api\State\Payload\BookPayload;
use App\Persistence\Repository\BookRepositoryInterface;

/**
 * @implements ProcessorInterface<BookPayload, BookResource>
 */
final readonly class UpdateBookProcessor implements ProcessorInterface
{
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $book = $this->bookRepository->ofId($uriVariables['id']);

        $book->update(...(array)$data);

        $this->bookRepository->save($book);

        return BookResource::fromModel($book);
    }
}
