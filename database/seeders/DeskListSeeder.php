<?php

namespace Database\Seeders;

use App\Models\Desk;
use App\Models\DeskList;
use Illuminate\Database\Seeder;

class DeskListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desks = Desk::all();

        $desks->each(function ($desk, $key) {
            DeskList::factory(rand(1, 4))->create(['desk_id' => $desk->id]);
        });
    }
}
