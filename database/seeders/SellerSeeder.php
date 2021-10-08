<?php

namespace Database\Seeders;

use App\Seller\Infrastructure\Persistence\Eloquent\SellerModel;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellerModel::factory((int) env('ALEGRA_SELLERS_TO_SEED', 20))->create();
    }
}
