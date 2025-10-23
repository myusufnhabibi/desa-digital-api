<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => [
            'menu'
        ],

        'head-of-family' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'family-member' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'social-assistance' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'social-assistance-recipient' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'event' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'event-participant' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'development' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'development-applicant' => [
            'menu',
            'create',
            'update',
            'delete',
            'list',
        ],

        'profile' => [
            'menu',
            'create',
            'update',
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $key => $values) {
            foreach ($values as $action) {
                $permissionName = $key . '-' . $action;
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'sanctum',
                ]);
            }
        }
    }
}
