<?php

namespace Database\Seeders;

use App\Models\Recruiter;
use Illuminate\Database\Seeder;

class RecruiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recruiter::create([
            'name' => 'Recruiter A',
        ]);

        Recruiter::create([
            'name' => 'Recruiter B',
        ]);

        Recruiter::create([
            'name' => 'Recruiter C',
        ]);

    }
}
