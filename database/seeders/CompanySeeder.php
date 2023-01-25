<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(2)->create();
        $connection = 'sqlite';
        $companies = Company::factory(2)->make();
        $companies->each(function ($model) use ($connection) {
            $model->setConnection($connection);
            $model->save();
        });
    }

}
