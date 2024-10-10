<?php

declare(strict_types=1);

namespace App\Api\Resources;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\State\Payload\BookPayload;
use App\Api\State\Processor\CreateBookProcessor;
use App\Api\State\Processor\DeleteBookProcessor;
use App\Api\State\Processor\UpdateBookProcessor;
use App\Api\State\Provider\BookCollectionProvider;
use App\Api\State\Provider\BookItemProvider;
use App\Model\Book;

#[ApiResource(shortName: 'Book')]
#[Get(
    uriTemplate: '/books/{id}',
    provider: BookItemProvider::class
)]
#[GetCollection(
    uriTemplate: '/books',
    provider: BookCollectionProvider::class,
)]
#[Post(
    uriTemplate: '/books',
    input: BookPayload::class,
    processor: CreateBookProcessor::class
)]
#[Patch(
    uriTemplate: '/books/{id}',
    input: BookPayload::class,
    provider: BookItemProvider::class,
    processor: UpdateBookProcessor::class
)]
#[Delete(
    uriTemplate: '/books/{id}',
    provider: BookItemProvider::class,
    processor: DeleteBookProcessor::class
)]
final class BookResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        public string $id,
        public string $title,
        public string $author,
        public string $isbn
    ) {
    }

    public static function fromModel(Book $book): self
    {
        return new self(
            $book->id(),
            $book->title(),
            $book->author(),
            $book->isbn()
        );
    }
}
