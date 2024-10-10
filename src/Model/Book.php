<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Uid\AbstractUid;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'book')]
final class Book
{
    public function  __construct(
        #[ORM\Column]
        private string $title,

        #[ORM\Column]
        private string $author,

        #[ORM\Column]
        private string $isbn,

        #[ORM\Id]
        #[ORM\Column(name: 'id', type: 'uuid')]
        private ?AbstractUid $id = null,
    ) {
        $this->id = Uuid::v7();
    }

    public function update(
        ?string $title = null,
        ?string $author = null,
        ?string $isbn = null
    ): void {
        $this->title = $title ?? $this->title;
        $this->author = $author ?? $this->author;
        $this->isbn = $isbn ?? $this->isbn;
    }

    public function id(): string
    {
        return $this->id->toString();
    }

    public function title(): string
    {
        return $this->title;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function isbn(): string
    {
        return $this->isbn;
    }
}
