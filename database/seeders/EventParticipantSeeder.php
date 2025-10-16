<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\HeadOfFamily;
use Database\Factories\EventParticipantFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $headogFamily = HeadOfFamily::all();

        foreach ($events as $event) {
            foreach ($headogFamily as $head) {
                EventParticipantFactory::new()->create([
                    'event_id' => $event->id,
                    'head_of_family_id' => $head->id,
                ]);
            }
        }
    }
}
