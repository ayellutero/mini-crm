<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = factory(App\Employee::class, 100)->create();
    }
}
