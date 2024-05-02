<?php

namespace Database\Seeders;

use Google\Service\AdExchangeBuyer\Resource\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TunedModelSeeder::class
        ]);
    }
}
