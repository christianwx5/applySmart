<?php

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
        // $this->call(UsersTableSeeder::class);

        // app\User::create([
        //     '' => '',
        //     '' => '',
        //     '' => '',
        // ]);

        factory(App\JobOffer::class, 5)->create();
    }
}
