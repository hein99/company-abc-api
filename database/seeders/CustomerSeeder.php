<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()
            ->count(5)
            ->hasPurchaseTransactions(10)
            ->create();

        Customer::factory()
            ->count(10)
            ->hasPurchaseTransactions(5)
            ->create();

        Customer::factory()
            ->count(7)
            ->hasPurchaseTransactions(3)
            ->create();
        
        Customer::factory()
            ->count(3)
            ->hasPurchaseTransactions(1)
            ->create();
        
    }
}
