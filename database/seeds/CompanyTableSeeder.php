<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = factory(App\Company::class, 100)->create();
    }
}
