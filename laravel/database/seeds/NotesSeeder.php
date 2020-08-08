<?php

use Illuminate\Database\Seeder;
use App\Models\Note;
use Faker\Factory;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++)
        {
            $table = new Note();
            $table->title = $faker->jobTitle();
            $table->description = $faker->realText();
            $table->save();
        }
    }
}
