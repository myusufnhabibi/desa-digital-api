<?php

namespace Database\Seeders;

use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(26)->create()->each(function ($user) {
            HeadOfFamilyFactory::new()->count(1)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
