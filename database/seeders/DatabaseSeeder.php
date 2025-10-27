<?php

namespace Database\Seeders;

use App\Models\SocialAssistance;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            HeadOfFamilySeeder::class,
            FamilyMemberSeeder::class,
            SocialAssistanceSeeder::class,
            SocialAssistanceRecepientSeeder::class,
            DevelopmentSeeder::class,
            DevelopmentApplicantSeeder::class,
            EventSeeder::class,
            EventParticipantSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
