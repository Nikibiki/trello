<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cards = Card::all();

        $cards->each(function ($card) {
            Task::factory(rand(5, 10))->create(['card_id' => $card->id]);
        });
    }
}
