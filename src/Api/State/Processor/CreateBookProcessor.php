<?php

declare(strict_types=1);

namespace App\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resources\BookResource;
use App\Api\State\Payload\BookPayload;
use App\Model\Book;
use App\Persistence\Repository\BookRepositoryInterface;

/**
 * @implements ProcessorInterface<BookPayload, BookResource>
 */
final readonly class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): BookResource
    {
        $book = new Book(title: $data->title, author: $data->author, isbn: $data->isbn);

        $this->bookRepository->save($book);

        return BookResource::fromModel($book);
    }
}
