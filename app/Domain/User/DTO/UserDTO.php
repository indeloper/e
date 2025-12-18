<?php

namespace App\Domain\User\DTO;

use Spatie\LaravelData\Data;

class UserDTO extends Data
{
    public function __construct(
        public ?string $email = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $patronymic = null,
        public ?string $password = null,
        public int $external_id = 0,
        public bool $is_active = true,
        public bool $is_blocked = false,
        public bool $is_super_admin = false,
    ) {
    }
}

