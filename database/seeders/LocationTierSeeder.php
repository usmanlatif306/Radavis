<?php

namespace Database\Seeders;

use App\Models\LocationTier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            [
                'name' => 'Location 1',
                'starting' => '0',
                'ending' => '20',
                'price' => '6.70',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 2',
                'starting' => '20.01',
                'ending' => '40',
                'price' => '8.10',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 3',
                'starting' => '40.01',
                'ending' => '60',
                'price' => '10.40',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 4',
                'starting' => '60.01',
                'ending' => '80',
                'price' => '12.30',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 5',
                'starting' => '80.01',
                'ending' => '100',
                'price' => '13.80',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 6',
                'starting' => '100.01',
                'ending' => '120',
                'price' => '15.70',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 7',
                'starting' => '120.01',
                'ending' => '140',
                'price' => '17.15',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 8',
                'starting' => '140.01',
                'ending' => '160',
                'price' => '19.15',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 9',
                'starting' => '160.01',
                'ending' => '180',
                'price' => '21.05',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 10',
                'starting' => '180.01',
                'ending' => '200',
                'price' => '23.20',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Location 11',
                'starting' => '200.01',
                'ending' => '5000',
                'price' => '23.20',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        LocationTier::insert($locations);
    }
}
