<?php

use Illuminate\Database\Seeder;
use \App\Models\PlayerSkill;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlayerSkill::create([
            'title' => 'Shoot',
        ]);

        PlayerSkill::create([
            'title' => 'Dribbling',
        ]);

        PlayerSkill::create([
            'title' => 'Speed',
        ]);

        PlayerSkill::create([
            'title' => 'Free-kick',
        ]);
    }
}
