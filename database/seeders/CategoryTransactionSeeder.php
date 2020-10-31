<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class CategoryTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Categories
        Category::factory()
                ->count(20)
                ->create();

        // Create Transactions
        Transaction::factory()
                ->count(20)
                ->create();

        // Get all category
        $categories = Category::all();

        // Populate the pivot table
        // Attaches randomly from 1 to 3 category to each transaction
        Transaction::all()->each(function ($transaction) use ($categories) {
            $transaction->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
