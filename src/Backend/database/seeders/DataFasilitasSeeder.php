<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataFasilitas;
use Faker\Factory as Faker;

class DataFasilitasSeeder extends Seeder
{
    public function run(int $jumlah = 10): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < $jumlah; $i++) {
            DataFasilitas::create([
                'nama_fasilitas' => $faker->words(2, true),
                'deskripsi' => $faker->sentence(),
                'kategori' => $faker->randomElement(['Elektronik', 'Furniture', 'Kendaraan']),
                'jumlah' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['tersedia', 'dipinjam', 'rusak']),
            ]);
        }
    }
}
