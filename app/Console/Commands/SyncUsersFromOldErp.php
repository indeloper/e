<?php

namespace App\Console\Commands;

use App\Application\DTOs\OldSystemUserDTO;
use App\Domain\User\Actions\UpsertUserFromOldErpDataAction;
use App\Domain\User\DTO\UserDTO;
use App\Infrastructure\ExternalApi\OldErpApiClient;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class SyncUsersFromOldErp extends Command
{
    protected $signature = 'users:sync-from-old-erp {--same-pass : Use "password" for all users}';

    protected $description = 'Синхронизация пользователей со старой ERP';

    public function handle(OldErpApiClient $client, UpsertUserFromOldErpDataAction $upsertUserFromOldErpData): void
    {
        try {
            $this->info('Starting user synchronization from OLD ERP...');
            $users = $client->getUsers();
            $this->info('Fetched ' . count($users) . ' users from external system.');

            $useSamePass = $this->option('same-pass');
            $defaultPassword = Hash::make('password');

            foreach ($users as $userData) {
                $oldDto = OldSystemUserDTO::fromArray($userData);

                if ($oldDto->isValid() && !$oldDto->is_deleted && $oldDto->email) {
                    $userDto = new UserDTO(
                        email: $oldDto->email,
                        first_name: $oldDto->first_name,
                        last_name: $oldDto->last_name,
                        patronymic: $oldDto->patronymic,
                        password: $useSamePass ? $defaultPassword : ($oldDto->password ?? $defaultPassword),
                        external_id: $oldDto->id,
                        is_active: $oldDto->status === 1,
                    );

                    $localUser = $upsertUserFromOldErpData($userDto);

                    $this->info("User {$localUser->full_name} ({$localUser->email}) synced successfully.");
                } else {
                    $this->warn("Skipping user ID {$oldDto->id} due to invalid data or deletion status.");
                }
            }

            $this->info('User synchronization completed.');
        } catch (Exception $exception) {
            $this->error("Error during user synchronization: " . $exception->getMessage());
            Log::error('User sync error', ['exception' => $exception]);
        }
    }
}

