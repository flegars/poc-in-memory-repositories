<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Model\Book;
use App\Persistence\InMemory\BookInMemoryRepository;
use App\Persistence\Repository\BookRepositoryInterface;

final class BookCrudTest extends ApiTestCase
{
    public function testGetBooks(): void
    {
        $client = static::createClient();
        $bookRepository = $client->getContainer()->get(BookRepositoryInterface::class);

        static::assertInstanceOf(BookInMemoryRepository::class, $bookRepository);

        for ($i = 0; $i < 10; $i++) {
            $book = new Book(
                title: 'Book ' . $i,
                author: 'Author ' . $i,
                isbn: 'ISBN ' . $i,
            );

            $bookRepository->save($book);
        }

        static::assertEquals(10, $bookRepository->count());

        $response = $client->request('GET', '/api/books');
        static::assertResponseIsSuccessful();
        static::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        static::assertEquals(10, $response->toArray()['totalItems']);
    }

    public function testGetBook(): void
    {
        $client = static::createClient();
        $bookRepository = $client->getContainer()->get(BookRepositoryInterface::class);

        $book = new Book(
            title: 'In memoria veritas',
            author: 'FLG',
            isbn: '9781234567897',
        );

        $bookRepository->save($book);

        $client->request('GET', sprintf('/api/books/%s', $book->id()));
        static::assertResponseIsSuccessful();
        static::assertJsonContains([
            '@id' => '/api/books/' . $book->id(),
            'id' => $book->id(),
            'title' => 'In memoria veritas',
            'author' => 'FLG',
            'isbn' => '9781234567897'
        ]);
    }

    public function testCreateBook(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/books', [
           'json' => [
               'title' => 'In memoria veritas',
               'author' => 'FLG',
               'isbn' => '9781234567897'
           ]
        ]);

        static::assertResponseIsSuccessful();
        static::assertJsonContains([
            'title' => 'In memoria veritas',
            'author' => 'FLG',
            'isbn' => '9781234567897'
        ]);
    }

    public function testUpdateBook(): void
    {
        $client = static::createClient();
        $bookRepository = $client->getContainer()->get(BookRepositoryInterface::class);

        $book = new Book(
            title: 'In memoria veritas',
            author: 'FLG',
            isbn: '9781234567897',
        );

        $bookRepository->save($book);

        $client->request('PATCH', sprintf('/api/books/%s', $book->id()), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json'
            ],
            'json' => [
                'title' => 'Changed title'
            ]
        ]);

        static::assertResponseIsSuccessful();
        static::assertJsonContains(['title' => 'Changed title']);
    }

    public function testDeleteBook(): void
    {
        $client = static::createClient();
        $bookRepository = $client->getContainer()->get(BookRepositoryInterface::class);

        $book = new Book(
            title: 'In memoria veritas',
            author: 'FLG',
            isbn: '9781234567897',
        );

        $bookRepository->save($book);

        $client->request('DELETE', sprintf('/api/books/%s', $book->id()));
        static::assertResponseIsSuccessful();
    }
}
