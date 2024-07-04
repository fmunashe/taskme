<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{

    public function run(): void
    {
        $types = [
            ['record_status_id' => 1, 'eventType' => 'Meeting', 'eventDescription' => 'Meeting Event'],
            ['record_status_id' => 1, 'eventType' => 'Work', 'eventDescription' => 'Work Event'],
        ];
        foreach ($types as $type) {
            EventType::query()->firstOrCreate($type, $type);
        }
    }
}
