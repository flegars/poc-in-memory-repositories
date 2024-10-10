<?php

declare(strict_types=1);

namespace App\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resources\BookResource;
use App\Persistence\Repository\BookRepositoryInterface;
use Webmozart\Assert\Assert;

/**
 * @implements ProcessorInterface<BookResource, null>
 */
final readonly class DeleteBookProcessor implements ProcessorInterface
{
    public function __construct(private BookRepositoryInterface $bookRepository)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        Assert::isInstanceOf($data, BookResource::class);

        $book = $this->bookRepository->ofId($data->id);
        $this->bookRepository->delete($book);

        return null;
    }
}
