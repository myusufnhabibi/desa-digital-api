<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use App\Models\SocialAssistance;
use Database\Factories\SocialAssistanceRecepientFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialAssistanceRecepientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialAssistance = SocialAssistance::all();
        $headogFamily = HeadOfFamily::all();

        foreach ($socialAssistance as $assistance) {
            foreach ($headogFamily as $head) {
                SocialAssistanceRecepientFactory::new()->create([
                    'social_assistance_id' => $assistance->id,
                    'head_of_family_id' => $head->id,
                ]);
            }
        }
    }
}
