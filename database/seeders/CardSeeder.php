<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\DeskList;
use App\Models\Task;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deskLists = DeskList::all();

        $deskLists->each(function ($list) {
            Card::factory(rand(1,3))->create(['desk_list_id' => $list->id]);
        });
    }
}
