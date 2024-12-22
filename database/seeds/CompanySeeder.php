<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() { 
        // Crear 10 registros usando el factory
        factory(Company::class, 10)->create(); 
    }
}
