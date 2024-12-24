<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Christian Di Santo',
            'email' => 'disantochistian@gmail.com',
            'password' => bcrypt('admin123')
        ]);

        factory(User::class, 5)->create();
    }
}
