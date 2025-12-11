<?php

namespace Database\Seeders;

use App\Models\StepCategory;
use Illuminate\Database\Seeder;

class StepCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            '1st Interview',
            'Tech Assessment',
            'Offer',
        ];

        foreach ($categories as $category) {
            StepCategory::create(['name' => $category]);
        }
    }
}
