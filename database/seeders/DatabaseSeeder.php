<?php

namespace Database\Seeders;

use App\Models\History;
use Carbon\Carbon;
use Database\Factories\HistoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->makeHistory(30 * 6);
    }

    private function makeHistory($count)
    {
        $now = Carbon::now();
        for ($i=0; $i < $count; $i++) {
            $now->subDay();
            History::factory()->create(['date_at' => $now]);
        }
    }
}
