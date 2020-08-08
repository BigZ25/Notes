<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory;

class UsersSeeder extends Seeder
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
            $table = new User();
            $table->name = $faker->name();
            $table->email = $faker->email();
            $table->password = $faker->password();
            $table->save();
        }
    }
}
