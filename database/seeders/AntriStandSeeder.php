<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AntriStandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $today = Carbon::now()->format('Y-m-d');

        for($i = 1; $i <=15; $i++) {
            DB::table('tbl_antri_stand')->insert([
                'nama' => $faker->name,
                'email' =>$faker->unique()->safeEmail(),
                'tanggal_pesan' => $today,
                'kd_stand' => 'FT',
                'nomor_antri' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

         for($i = 1; $i <=10; $i++) {
            DB::table('tbl_antri_stand')->insert([
                'nama' => $faker->name,
                'email' =>$faker->unique()->safeEmail(),
                'tanggal_pesan' => $today,
                'kd_stand' => 'LK',
                'nomor_antri' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
