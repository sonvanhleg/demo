<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class ComputersTableSeeder extends Seeder
{
 /**
 * Run the database seeds.
 */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            DB::table('computers')->insert([
                'computer_name' => $faker->unique()->word,
                'model' => $faker->word . ' ' . $faker->numberBetween(1000, 9999),
                'operating_system' => $faker->randomElement(['Windows 10', 'Windows 11', 'Ubuntu 20.04', 'macOS Big Sur']),
                'processor' => $faker->randomElement(['Intel Core i5', 'Intel Core i7', 'AMD Ryzen 5', 'AMD Ryzen 7']),
                'memory' => $faker->numberBetween(4, 64),
                'available' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}