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
        $this->call([
            CompanySeeder::class,
            //Otros seeders
        ]);

        // app\User::create([
        //     '' => '',
        //     '' => '',
        //     '' => '',
        // ]);

        factory(App\JobOffer::class, 5)->create();
    }
}
