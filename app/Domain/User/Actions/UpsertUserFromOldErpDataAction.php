<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTO\UserDTO;
use App\Models\User;

class UpsertUserFromOldErpDataAction
{
    public function __invoke(UserDTO $userData): User
    {
        $fullName = trim("{$userData->last_name} {$userData->first_name} {$userData->patronymic}");
        if (empty($fullName)) {
            $fullName = explode('@', $userData->email)[0];
        }

        return User::updateOrCreate(
            [
                'email' => $userData->email,
            ],
            [
                'name' => $fullName,
                'first_name' => $userData->first_name,
                'last_name' => $userData->last_name,
                'patronymic' => $userData->patronymic,
                'password' => $userData->password,
                'external_id' => $userData->external_id,
                'is_active' => $userData->is_active,
                'is_blocked' => $userData->is_blocked,
                'is_super_admin' => $userData->is_super_admin,
                'last_synced_at' => now(),
            ]
        );
    }
}

