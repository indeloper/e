<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->string('first_name')->nullable()->after('name');
            $blueprint->string('last_name')->nullable()->after('first_name');
            $blueprint->string('patronymic')->nullable()->after('last_name');
            $blueprint->unsignedBigInteger('external_id')->unique()->nullable()->after('id');
            $blueprint->boolean('is_active')->default(true)->after('password');
            $blueprint->boolean('is_blocked')->default(false)->after('is_active');
            $blueprint->boolean('is_super_admin')->default(false)->after('is_blocked');
            $blueprint->timestamp('last_synced_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->dropColumn([
                'first_name',
                'last_name',
                'patronymic',
                'external_id',
                'is_active',
                'is_blocked',
                'is_super_admin',
                'last_synced_at',
            ]);
        });
    }
};
