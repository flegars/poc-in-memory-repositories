<?php

declare(strict_types=1);

namespace App\Api\State\Payload;

final class BookPayload
{
    public function __construct(
        public ?string $title = null,
        public ?string $author = null,
        public ?string $isbn = null
    ) {
    }
}
