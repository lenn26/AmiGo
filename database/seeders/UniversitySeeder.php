<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            [
                'name' => "IUT d'Amiens (Avenue des Facultés) - BUT, GEA, Info, Bio",
                'address' => 'Avenue des Facultés',
                'latitude' => 49.872702,
                'longitude' => 2.263533,
                'type' => 'IUT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "La Citadelle (UPJV) - Lettres, Histoire, Philo",
                'address' => 'Rue des Français Libres',
                'latitude' => 49.902251,
                'longitude' => 2.299663,
                'type' => 'UPJV',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // Adding a test one to ensure update works
                'name' => "Pôle Santé / CHU Amiens Sud",
                'address' => 'Avenue René Laënnec',
                'latitude' => 49.873000,
                'longitude' => 2.276000,
                'type' => 'Campus',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('UNIVERSITIES')->insert($universities);
    }
}
