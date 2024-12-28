<?php

use Illuminate\Database\Seeder;
use App\JobPriority;

class JobPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(JobPriority::class, 4)->create(); 
    }
}
