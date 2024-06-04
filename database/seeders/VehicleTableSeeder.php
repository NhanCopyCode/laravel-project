<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();

        $model_id_array = [1, 5];
        $carrentalstore_id_array = [31, 35];

        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('vehicles')->insert([
                'CarRentalStore_id' => $carrentalstore_id_array[array_rand($carrentalstore_id_array)],
                'model_id' => $model_id_array[array_rand($model_id_array)],
                'description' => 'Xe test ' . rand(1, 200),
                'license_plate' => '75A-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT),
                'rental_price_day' => rand(100000, 500000) * 1000,
                'vehicle_status_id' => 1,
                'vehicle_image_id' => rand(1, 7),
            ]);
        }
    }
}
