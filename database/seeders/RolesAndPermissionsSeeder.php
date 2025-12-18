<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Сброс кэша ролей и прав
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Список всех прав, разбитых по группам
        $permissions = [
            'users' => [
                'users.view' => 'Просмотр пользователей',
                'users.create' => 'Создание пользователей',
                'users.edit' => 'Редактирование пользователей',
                'users.delete' => 'Удаление пользователей',
            ],
            'roles' => [
                'roles.view' => 'Просмотр ролей',
                'roles.manage' => 'Управление ролями и правами',
            ],
            'logistics' => [
                'logistics.view' => 'Просмотр логистики',
                'logistics.manage' => 'Управление рейсами и перевозчиками',
            ],
            'objects' => [
                'objects.view' => 'Просмотр объектов',
                'objects.manage' => 'Управление объектами',
            ],
            'system' => [
                'system.debug' => 'Доступ к дебаг-панели',
                'system.settings' => 'Настройки системы',
            ],
        ];

        foreach ($permissions as $group => $items) {
            foreach ($items as $name => $label) {
                Permission::findOrCreate($name);
            }
        }

        // Создаем базовые роли, если их нет
        Role::findOrCreate('Super Admin');
        
        $admin = Role::findOrCreate('Администратор');
        $admin->givePermissionTo(Permission::all());

        $manager = Role::findOrCreate('Менеджер');
        $manager->givePermissionTo([
            'users.view',
            'logistics.view',
            'objects.view',
        ]);
    }
}
