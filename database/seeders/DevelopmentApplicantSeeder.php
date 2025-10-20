<?php

namespace Database\Seeders;

use App\Models\Development;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $development = Development::all();
        $user = User::take(5)->get();

        foreach ($development as $dev) {
            foreach ($user as $usr) {
                \App\Models\DevelopmentApplicant::create([
                    'development_id' => $dev->id,
                    'user_id' => $usr->id,
                    'status' => 'pending',
                ]);
            }
        }
    }
}
