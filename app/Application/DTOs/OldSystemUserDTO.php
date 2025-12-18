<?php

namespace App\Application\DTOs;

use Spatie\LaravelData\Data;

class OldSystemUserDTO extends Data
{
    public function __construct(
        public int $id,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $patronymic = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?int $status = null,
        public bool $is_deleted = false,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            patronymic: $data['patronymic'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            status: $data['status'] ?? null,
            is_deleted: (bool)($data['is_deleted'] ?? false),
        );
    }

    public function isValid(): bool
    {
        return isset($this->id) && $this->email && filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
}

